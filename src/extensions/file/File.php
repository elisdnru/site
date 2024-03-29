<?php

namespace app\extensions\file;

use app\components\AntiMagic;
use RuntimeException;
use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * CFile class file.
 *
 * CFile provides common methods to manipulate filesystem objects (files and
 * directories) from under Yii Framework (http://www.yiiframework.com)
 *
 * @version 0.9
 *
 * @author idle sign <idlesign@yandex.ru>
 * @link http://www.yiiframework.com/extension/cfile/
 * @copyright Copyright &copy; 2009-2011 Igor 'idle sign' Starikov
 * @license LICENSE.txt
 */
class File
{
    use AntiMagic;

    /**
     * @var array object instances array with key set to $filepath
     */
    private static $instances = [];
    /**
     * @var string filesystem object path submitted by user
     */
    private $filepath;
    /**
     * @var string real filesystem object path figured by script on the basis
     * of $filepath
     */
    private $realpath;
    /**
     * @var boolean 'true' if filesystem object described by $realpath exists
     */
    private $exists;
    /**
     * @var boolean 'true' if filesystem object described by $realpath is
     * a regular file
     */
    private $isFile = false;
    /**
     * @var boolean 'true' if filesystem object described by $realpath is
     * a directory
     */
    private $isDir = false;
    /**
     * @var boolean 'true' if file described by $realpath is uploaded
     */
    private $isUploaded = false;
    /**
     * @var boolean 'true' if filesystem object described by $realpath is
     * readable
     */
    private $readable;
    /**
     * @var boolean 'true' if filesystem object described by $realpath
     * writeable
     */
    private $writeable;
    /**
     * @var string basename of the file (eg. 'myfile.htm'
     * for '/var/www/htdocs/files/myfile.htm')
     */
    private $basename;
    /**
     * @var string name of the file (eg. 'myfile'
     * for '/var/www/htdocs/files/myfile.htm')
     */
    private $filename;
    /**
     * @var string directory name of the filesystem object
     * (eg. '/var/www/htdocs/files' for '/var/www/htdocs/files/myfile.htm')
     */
    private $dirname;
    /**
     * @var string file extension(eg. 'htm'
     * for '/var/www/htdocs/files/myfile.htm')
     */
    private $extension;
    /**
     * @var string file extension(eg. 'text/html'
     * for '/var/www/htdocs/files/myfile.htm')
     */
    private $mimeType;
    /**
     * @var integer the time the filesystem object was last modified
     * (Unix timestamp eg. '1213760802')
     */
    private $timeModified;
    /**
     * @var string filesystem object size formatted (eg. '70.4 KB') or
     * in bytes (eg. '72081') see {@link getSize} parameters
     */
    private $size;
    /**
     * @var boolean filesystem object has contents flag
     */
    private $isEmpty;
    /**
     * @var mixed filesystem object owner name (eg. 'idle') or
     * in ID (eg. '1000') see {@link getOwner} parameters
     */
    private $owner;
    /**
     * @var mixed filesystem object group name (eg. 'apache') or
     * in ID (eg. '127') see {@link getGroup} parameters
     */
    private $group;
    /**
     * @var string filesystem object permissions (considered octal eg. '0755')
     */
    private $permissions;
    /**
     * @var resource file pointer resource (for {@link open} & {@link close})
     */
    private $handle;
    /**
     * @var UploadedFile object instance
     */
    private $uploadedInstance;


    /**
     * Returns the instance of CFile for the specified file.
     *
     * @param string $filePath Path to file specified by user
     * @return File instance
     */
    private static function getInstance(string $filePath): self
    {
        if (!array_key_exists($filePath, self::$instances)) {
            self::$instances[$filePath] = new self();
        }
        return self::$instances[$filePath];
    }

    /**
     * Logs a message.
     *
     * @param string $message Message to be logged
     * 'error', 'info', see CLogger constants definitions)
     */
    private function addLog(string $message): void
    {
        Yii::info($message . ' (obj: ' . $this->getRealPath() . ')', 'ext.file');
    }

    /**
     * Basic CFile method. Sets CFile object to work with specified filesystem
     * object.
     * Essentially path supplied by user is resolved into real path (see
     * {@link getRealPath}), all the other property getting methods should use
     * that real path.
     * Uploaded files are supported through {@link CUploadedFile} Yii class.
     * Path sluges are supported through {@link getPathOfSlug} Yii method.
     *
     * @param string $filePath Path to the file specified by user, if not set
     * exception is raised
     * @param boolean $greedy If true file properties (such as 'Size', 'Owner',
     * 'Permission', etc.) would be autoloaded
     * @return File CFile instance for the specified filesystem object
     * @throws RuntimeException
     */
    public function set(string $filePath, bool $greedy = false): File
    {
        if (trim($filePath) !== '') {
            $uploaded = null;

            if (strpos($filePath, '\\') === false && strpos($filePath, '/') === false) {
                $uploaded = UploadedFile::getInstanceByName($filePath);
                if ($uploaded) {
                    $filePath = $uploaded->tempName;
                    Yii::debug('File "' . $filePath . '" is identified as uploaded', 'ext.file');
                } elseif ($pathOfSlug = Yii::getSlug($filePath)) {
                    Yii::debug(
                        'The string supplied to ' . __METHOD__ . ' method - "' .
                            $filePath . '" is identified as the slug to "' . $pathOfSlug . '"',
                        'ext.file'
                    );
                    $filePath = $pathOfSlug;
                }
            }

            clearstatcache();
            $realPath = $this->realPath($filePath);
            $instance = self::getInstance($realPath);
            $instance->filepath = $filePath;
            $instance->realpath = $realPath;

            if ($instance->exists()) {
                $instance->uploadedInstance = $uploaded;

                $instance->pathInfo();
                $instance->getReadable();
                $instance->getWriteable();

                if ($greedy) {
                    $instance->getIsEmpty();
                    $instance->getSize();
                    $instance->getOwner();
                    $instance->getGroup();
                    $instance->getPermissions();
                    $instance->getTimeModified();
                    if ($instance->getIsFile()) {
                        $instance->getMimeType();
                    }
                }
            }
            return $instance;
        }

        throw new RuntimeException('Path to filesystem object is not specified within ' . __METHOD__ . ' method');
    }

    /**
     * Populates basic CFile properties (i.e. 'Dirname', 'Basename', etc.)
     * using values resolved by pathinfo() php function.
     * Detects filesystem object type (file, directory).
     */
    private function pathInfo(): void
    {
        if (is_file($this->realpath)) {
            $this->isFile = true;
        } elseif (is_dir($this->realpath)) {
            $this->isDir = true;
        }

        if ($this->uploadedInstance) {
            $this->isUploaded = true;
        }

        $pathinfo = pathinfo($this->isUploaded ? $this->uploadedInstance->name : $this->realpath);

        $this->dirname = $pathinfo['dirname'];
        $this->basename = $pathinfo['basename'];

        // PHP version < 5.2 workaround
        if (!isset($pathinfo['filename'])) {
            $this->filename = substr($pathinfo['basename'], 0, strrpos($pathinfo['basename'], '.'));
        } else {
            $this->filename = $pathinfo['filename'];
        }
        if (array_key_exists('extension', $pathinfo)) {
            $this->extension = $pathinfo['extension'];
        } else {
            $this->extension = null;
        }
    }

    /**
     * Returns real filesystem object path figured by script
     * (see {@link realPath}) on the basis of user supplied $filepath.
     * If $realpath property is set, returned value is read from that property.
     *
     * @param string $dir_separator Directory separator char (depends upon OS)
     * @return string Real file path
     */
    public function getRealPath($dir_separator = DIRECTORY_SEPARATOR): string
    {
        if (!isset($this->realpath)) {
            $this->realpath = $this->realPath($this->filepath, $dir_separator);
        }

        return $this->realpath;
    }

    /**
     * Base real filesystem object path resolving method.
     * Returns real path resolved from the supplied path.
     *
     * @param string $suppliedPath Path from which real filesystem object path
     * should be resolved
     * @param string $dir_separator Directory separator char (depends upon OS)
     * @return string Real file path
     */
    private function realPath(string $suppliedPath, $dir_separator = DIRECTORY_SEPARATOR): string
    {
        $currentPath = $suppliedPath;

        if ($currentPath === '') {
            return $dir_separator;
        }

        $winDrive = '';

        // Windows OS path type detection
        if (!strncasecmp(PHP_OS, 'win', 3)) {
            $currentPath = preg_replace('/[\\\\\/]/', $dir_separator, $currentPath);
            if (preg_match('/([a-zA-Z]\:)(.*)/', $currentPath, $matches)) {
                $winDrive = $matches[1];
                $currentPath = $matches[2];
            } else {
                $workingDir = getcwd();
                $winDrive = substr($workingDir, 0, 2);
                if ($currentPath[0] !== $dir_separator[0]) {
                    $currentPath = substr($workingDir, 3) . $dir_separator . $currentPath;
                }
            }
        } elseif ($currentPath[0] !== $dir_separator) {
            $currentPath = getcwd() . $dir_separator . $currentPath;
        }

        $pathsArr = [];
        foreach (explode($dir_separator, $currentPath) as $path) {
            if ($path !== '' && $path !== '.') {
                if ($path === '..') {
                    array_pop($pathsArr);
                } else {
                    $pathsArr[] = $path;
                }
            }
        }

        $realpath = $winDrive . $dir_separator . implode($dir_separator, $pathsArr);

        if ($currentPath !== $suppliedPath) {
            Yii::debug('Path "' . $suppliedPath . '" resolved into "' . $realpath . '"', 'ext.file');
        }

        return $realpath;
    }

    /**
     * Tests current filesystem object existance and returns boolean
     * (see {@link exists}).
     * If $exists property is set, returned value is read from that property.
     *
     * @return boolean 'True' if file exists, overwise 'false'
     */
    public function getExists(): bool
    {
        if (!isset($this->exists)) {
            $this->exists();
        }

        return $this->exists;
    }

    /**
     * Returns filesystem object type for the current file
     * (see {@link pathInfo}).
     * Tells whether filesystem object is a regular file.
     *
     * @return boolean 'True' if filesystem object is a regular file,
     * overwise 'false'
     */
    public function getIsFile(): bool
    {
        return $this->isFile;
    }

    /**
     * Returns filesystem object type for the current file
     * (see {@link pathInfo}).
     * Tells whether filesystem object is a directory.
     *
     * @return boolean 'True' if filesystem object is a directory,
     * overwise 'false'
     */
    public function getIsDir(): bool
    {
        return $this->isDir;
    }

    /**
     * Tells whether file is uploaded through a web form.
     *
     * @return boolean 'True' if file is uploaded, overwise 'false'
     */
    public function getIsUploaded(): bool
    {
        return $this->isUploaded;
    }

    /**
     * Returns filesystem object has-contents flag.
     * Directory considered empty if it doesn't contain descendants.
     * File considered empty if its size is 0 bytes.
     *
     * @return boolean 'True' if file is a directory, overwise 'false'
     */
    public function getIsEmpty(): bool
    {
        if (!isset($this->isEmpty)) {
            if (
                ($this->getIsFile() && $this->getSize(false) === 0) ||
                (!$this->getIsFile() && count($this->dirContents($this->realpath)) === 0)
            ) {
                $this->isEmpty = true;
            } else {
                $this->isEmpty = false;
            }
        }

        return $this->isEmpty;
    }

    /**
     * Tests whether the current filesystem object is readable and returns
     * boolean.
     * If $readable property is set, returned value is read from that property.
     *
     * @return boolean 'True' if filesystem object is readable, overwise 'false'
     */
    public function getReadable(): bool
    {
        if (!isset($this->readable)) {
            $this->readable = is_readable($this->realpath);
        }

        return $this->readable;
    }

    /**
     * Tests whether the current filesystem object is readable and returns
     * boolean.
     * If $writeable property is set, returned value is read from that
     * property.
     *
     * @return boolean 'True' if filesystem object is writeable,
     * overwise 'false'
     */
    public function getWriteable(): bool
    {
        if (!isset($this->writeable)) {
            $this->writeable = is_writable($this->realpath);
        }

        return $this->writeable;
    }

    /**
     * Base filesystem object existance resolving method.
     * Tests current filesystem object existance and returns boolean.
     *
     * @return boolean 'True' if filesystem object exists, overwise 'false'
     */
    private function exists(): bool
    {
        Yii::debug('Filesystem object availability test: ' . $this->realpath, 'ext.file');

        if (file_exists($this->realpath)) {
            $this->exists = true;
        } else {
            $this->exists = false;
        }

        if ($this->exists) {
            return true;
        }

        $this->addLog('Filesystem object not found');
        return false;
    }

    /**
     * Creates empty file if the current file doesn't exist.
     *
     * @return mixed Updated the current CFile object on success, 'false'
     * on fail.
     */
    public function create(): ?self
    {
        if (!$this->getExists()) {
            if ($this->open('w')) {
                $this->close();
                return $this->set($this->realpath);
            }

            $this->addLog('Unable to create empty file');
            return null;
        }

        $this->addLog('File creation failed. File already exists');
        return null;
    }

    /**
     * Creates empty directory defined either through {@link set} or through the
     * $directory parameter.
     *
     *
     * @param int $permissions Access permissions for the directory
     * @param string $directory Parameter used to create directory other than
     * supplied by {@link set} method of the CFile
     * @return mixed Updated the current CFile object on success, 'false'
     * on fail.
     */
    public function createDir($permissions = 0754, $directory = null): ?self
    {
        if ($directory === null) {
            $dir = $this->realpath;
        } else {
            $dir = $directory;
        }

        if (@mkdir($dir, $permissions, true) || is_dir($dir)) {
            if (!$directory) {
                return $this->set($dir);
            }
            return null;
        }

        $this->addLog('Unable to create empty directory "' . $dir . '"');
        return null;
    }

    /**
     * Opens (if not already opened) the current file using certain mode.
     * See fopen() php function for more info.
     *
     * For now used only internally.
     *
     * @param string $mode Type of access required to the stream
     * @return File|null Current CFile object on success, 'false' on fail.
     */
    private function open(string $mode): ?self
    {
        if ($this->handle === null) {
            if ($this->handle = fopen($this->realpath, $mode)) {
                return $this;
            }

            $this->addLog('Unable to open file using mode "' . $mode . '"');
        }
        return null;
    }

    /**
     * Closes (if opened) the current file pointer.
     * See fclose() php function for more info.
     *
     * For now used only internally.
     */
    private function close(): void
    {
        if ($this->handle !== null) {
            fclose($this->handle);
            $this->handle = null;
        }
    }

    /**
     * Returns owner of current filesystem object (UNIX systems).
     * Returned value depends upon $getName parameter value.
     * If $owner property is set, returned value is read from that property.
     *
     * @param boolean $getName Defaults to 'true', meaning that owner name
     * instead of ID should be returned.
     * @return mixed Owner name, or ID if $getName set to 'false'
     */
    public function getOwner($getName = true): mixed
    {
        if (!isset($this->owner)) {
            $this->owner = $this->getExists() ? fileowner($this->realpath) : null;
        }

        if (is_int($this->owner) && function_exists('posix_getpwuid') && $getName === true) {
            $owner = posix_getpwuid($this->owner);
            if ($owner) {
                $this->owner = $owner['name'];
            }
        }

        return $this->owner;
    }

    /**
     * Returns group of current filesystem object (UNIX systems).
     * Returned value depends upon $getName parameter value.
     * If $group property is set, returned value is read from that property.
     *
     * @param boolean $getName Defaults to 'true', meaning that group name
     * instead of ID should be returned.
     * @return mixed Group name, or ID if $getName set to 'false'
     */
    public function getGroup($getName = true): mixed
    {
        if (!isset($this->group)) {
            $this->group = $this->getExists() ? filegroup($this->realpath) : null;
        }

        if (is_int($this->group) && function_exists('posix_getgrgid') && $getName === true) {
            $group = posix_getgrgid($this->group);
            if ($group) {
                $this->group = $group['name'];
            }
        }

        return $this->group;
    }

    /**
     * Returns permissions of current filesystem object (UNIX systems).
     * If $permissions property is set, returned value is read from that
     * property.
     *
     * @return string Filesystem object permissions in octal format (i.e. '0755')
     */
    public function getPermissions(): string
    {
        if (!isset($this->permissions)) {
            $this->permissions = $this->getExists() ? substr(sprintf('%o', fileperms($this->realpath)), -4) : null;
        }

        return $this->permissions;
    }

    /**
     * Returns size of current filesystem object.
     * Returned value depends upon $format parameter value.
     * If $size property is set, returned value is read from that property.
     * Uses {@link dirSize} method for directory size calculation.
     *
     * @param mixed $format Number format (see {@link CNumberFormatter})
     * or 'false'
     * @return mixed Filesystem object size formatted (eg. '70.4 KB') or in
     * bytes (eg. '72081') if $format set to 'false'
     */
    public function getSize($format = '0.00'): mixed
    {
        if (!isset($this->size)) {
            if ($this->getIsFile()) {
                $this->size = $this->getExists() ? sprintf('%u', filesize($this->realpath)) : null;
            } else {
                $this->size = $this->getExists() ? sprintf('%u', $this->dirSize()) : null;
            }
        }
        $size = $this->size;

        if ($format !== false) {
            $size = $this->formatFileSize($this->size, $format);
        }

        return $size;
    }

    /**
     * Calculates the current directory size recursively fetching sizes of
     * all descendant files.
     *
     * This method is used internally and only for folders.
     * See {@link getSize} method params for detailed information.
     */
    private function dirSize(): int
    {
        $size = 0;
        foreach ($this->dirContents($this->realpath, true) as $item) {
            if (is_file($item)) {
                $size += sprintf('%u', filesize($item));
            }
        }

        return $size;
    }

    /**
     * Base filesystem object size format method.
     * Converts file size in bytes into human readable format (i.e. '70.4 KB')
     *
     * @param integer $bytes Filesystem object size in bytes
     * @param integer $format Number format (see {@link CNumberFormatter})
     * @return string Filesystem object size in human readable format
     */
    private function formatFileSize(int $bytes, int $format): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        $bytes = max($bytes, 0);
        $expo = floor(($bytes ? log($bytes) : 0) / log(1024));
        $expo = min($expo, count($units) - 1);

        $bytes /= 1024 ** $expo;

        return Yii::$app->formatter->asDecimal($bytes) . ' ' . $units[$expo];
    }

    /**
     * Returns the current file last modified time.
     * Returned Unix timestamp could be passed to php date() function.
     *
     * @return integer Last modified time Unix timestamp (eg. '1213760802')
     */
    public function getTimeModified(): ?int
    {
        if (empty($this->timeModified)) {
            $this->timeModified = $this->getExists() ? filemtime($this->realpath) : null;
        }

        return $this->timeModified;
    }

    /**
     * Returns the current file extension from $extension property set
     * by {@link pathInfo} (eg. 'htm' for '/var/www/htdocs/files/myfile.htm').
     *
     * @return string Current file extension without the leading dot
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * Returns the current file basename (file name plus extension) from
     * $basename property set by {@link pathInfo}
     * (eg. 'myfile.htm' for '/var/www/htdocs/files/myfile.htm').
     *
     * @return string Current file basename
     */
    public function getBasename(): ?string
    {
        return $this->basename;
    }

    /**
     * Returns the current file name (without extension) from $filename
     * property set by {@link pathInfo}
     * (eg. 'myfile' for '/var/www/htdocs/files/myfile.htm')
     *
     * @return string Current file name
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * Returns the current file directory name (without final slash) from
     * $dirname property set by {@link pathInfo}
     * (eg. '/var/www/htdocs/files' for '/var/www/htdocs/files/myfile.htm')
     *
     * @return string Current file directory name
     */
    public function getDirname(): ?string
    {
        return $this->dirname;
    }

    /**
     * Returns the current filesystem object contents.
     * Reads data from filesystem object if it is a regular file.
     * List files and directories inside the specified path if filesystem object
     * is a directory.
     *
     * @param boolean $recursive If 'true' method would return all directory
     * descendants
     * @param string $filter Filter to be applied to all directory descendants.
     * Could be a string, or an array of strings (perl regexp supported).
     * @return mixed The read data or 'false' on fail.
     */
    public function getContents($recursive = false, $filter = null): mixed
    {
        if ($this->getReadable()) {
            if ($this->getIsFile()) {
                if ($contents = file_get_contents($this->realpath)) {
                    return $contents;
                }
            } else {
                if ($contents = $this->dirContents($this->realpath, $recursive, $filter)) {
                    return $contents;
                }
            }
        }
        $this->addLog(
            'Unable to get filesystem object contents' . ($filter !== null ? ' *using supplied filter*' : '')
        );
        return null;
    }

    /**
     * Gets directory contents (descendant files and folders).
     *
     * @param string $directory Initial directory to get descendants for
     * @param boolean $recursive If 'true' method would return all descendants
     * recursively, otherwise just immediate descendants
     * @param string|array $filter Filter to be applied to all directory descendants.
     * Could be a string, or an array of strings (perl regexp supported).
     * See {@link filterPassed} method for further information on filters.
     * @return array Array of descendants filepaths
     */
    private function dirContents($directory = null, $recursive = false, $filter = []): array
    {
        $descendants = [];
        if (!$directory) {
            $directory = $this->realpath;
        }

        if ($filter !== null) {
            if (is_string($filter)) {
                $filter = [$filter];
            }

            foreach ($filter as $key => $rule) {
                if ($rule[0] !== '/') {
                    $filter[$key] = ltrim($rule, '.');
                }
            }
        }

        if ($contents = @scandir($directory . DIRECTORY_SEPARATOR)) {
            foreach ($contents as $key => $item) {
                $contents[$key] = $directory . DIRECTORY_SEPARATOR . $item;
                if (!in_array($item, ['.', '..'])) {
                    if ($this->filterPassed($contents[$key], $filter)) {
                        $descendants[] = $contents[$key];
                    }

                    if (is_dir($contents[$key]) && $recursive) {
                        $descendants = array_merge(
                            $descendants,
                            $this->dirContents($contents[$key], $recursive, $filter)
                        );
                    }
                }
            }
        } else {
            throw new RuntimeException(
                'Unable to get directory contents for "' . $directory . DIRECTORY_SEPARATOR . '"'
            );
        }

        return $descendants;
    }

    /**
     * Applies an array of filter rules to the string representing filepath.
     * Used internally by {@link dirContents} method.
     *
     * @param string $str String representing filepath to be filtered
     * @param array|null $filter An array of filter rules, where each rule is a
     * string, supposing that the string starting with '/' is a regular
     * expression. Any other string reated as an extension part of the
     * given filepath (eg. file extension)
     * @return boolean Returns 'true' if the supplied string matched one of
     * the filter rules.
     */
    private function filterPassed(string $str, ?array $filter): bool
    {
        $passed = false;

        if ($filter !== null) {
            foreach ($filter as $rule) {
                if ($rule[0] !== '/') {
                    $rule = '.' . $rule;
                    $passed = (bool)substr_count($str, $rule, strlen($str) - strlen($rule));
                } else {
                    $passed = (bool)preg_match($rule, $str);
                }

                if ($passed) {
                    break;
                }
            }
        } else {
            $passed = true;
        }

        return $passed;
    }

    /**
     * Writes contents (data) into the current file.
     * This method works only for files.
     *
     * @param string $contents Contents to be written
     * @param boolean $autocreate If 'true' file will be created automatically
     * @param integer $flags Flags for file_put_contents(). E.g.: FILE_APPEND
     * to append data to file instead of overwriting.
     * @return mixed Current CFile object on success, 'false' on fail.
     */
    public function setContents($contents = null, $autocreate = true, $flags = 0): ?self
    {
        if ($this->getIsFile()) {
            if ($autocreate && !$this->getExists()) {
                $this->create();
            }

            if ($this->getWriteable() && file_put_contents($this->realpath, $contents, $flags) !== false) {
                return $this;
            }

            $this->addLog('Unable to put file contents');
            return null;
        }
        $this->addLog(__METHOD__ . ' method is available only for files', 'warning');
        return null;
    }

    /**
     * Sets basename for the current file.
     * Lazy wrapper for {@link rename}.
     * This method works only for files.
     *
     * @param bool $basename New file basename (eg. 'mynewfile.txt')
     * @return mixed Current CFile object on success, 'false' on fail.
     */
    public function setBasename($basename = false): ?self
    {
        if ($this->getIsFile()) {
            if ($this->getIsUploaded()) {
                $this->addLog(
                    __METHOD__ . ' method is unavailable for uploaded files. ' .
                        'Please copy/move uploaded file from temporary directory',
                    'warning'
                );
                return null;
            }

            if ($this->getWriteable() && $basename !== false && $this->rename($basename)) {
                return $this;
            }

            $this->addLog('Unable to set file basename "' . $basename . '"');
            return null;
        }

        $this->addLog(__METHOD__ . ' method is available only for files', 'warning');
        return null;
    }

    /**
     * Sets the current file name.
     * Lazy wrapper for {@link rename}.
     * This method works only for files.
     *
     * @param bool $filename New file name (eg. 'mynewfile')
     * @return mixed Current CFile object on success, 'false' on fail.
     */
    public function setFilename($filename = false): ?self
    {
        if ($this->getIsFile()) {
            if ($this->getIsUploaded()) {
                $this->addLog(
                    __METHOD__ . ' method is unavailable for uploaded files. ' .
                        'Please copy/move uploaded file from temporary directory',
                    'warning'
                );
                return null;
            }

            if (
                $this->getWriteable() && $filename !== false &&
                $this->rename(str_replace($this->getFilename(), $filename, $this->getBasename()))
            ) {
                return $this;
            }

            $this->addLog('Unable to set file name "' . $filename . '"');
            return null;
        }

        $this->addLog(__METHOD__ . ' method is available only for files', 'warning');
        return null;
    }

    /**
     * Sets the current file extension.
     * If new extension is 'null' or 'false' current file extension is dropped.
     * Lazy wrapper for {@link rename}.
     * This method works only for files.
     *
     * @param string $extension New file extension (eg. 'txt')
     * @return mixed Current CFile object on success, 'false' on fail.
     */
    public function setExtension($extension = null): ?self
    {
        if ($this->getIsFile()) {
            if ($this->getIsUploaded()) {
                $this->addLog(
                    __METHOD__ . ' method is unavailable for uploaded files. ' .
                        'Please copy/move uploaded file from temporary directory',
                    'warning'
                );
                return null;
            }

            if ($this->getWriteable() && $extension !== false) {
                $extension = trim($extension);

                if ($extension === null || $extension === '') {
                    // drop current extension
                    $newBaseName = $this->getFilename();
                } else {
                    // apply new extension
                    $extension = ltrim($extension, '.');

                    if ($this->getExtension() === null) {
                        $newBaseName = $this->getFilename() . '.' . $extension;
                    } else {
                        $newBaseName = str_replace($this->getExtension(), $extension, $this->getBasename());
                    }
                }

                if ($this->rename($newBaseName)) {
                    return $this;
                }
            }

            $this->addLog('Unable to set file extension "' . $extension . '"');
            return null;
        }

        $this->addLog(__METHOD__ . ' method is available only for files', 'warning');
        return null;
    }

    /**
     * Sets the current filesystem object owner, updates $owner property
     * on success.
     * For UNIX systems.
     *
     * @param mixed $owner New owner name or ID
     * @return File|null Current CFile object on success, 'false' on fail.
     */
    public function setOwner(mixed $owner): ?self
    {
        if ($this->getExists() && chown($this->realpath, $owner)) {
            $this->owner = $owner;
            return $this;
        }

        $this->addLog('Unable to set owner for filesystem object to "' . $owner . '"');
        return null;
    }

    /**
     * Sets the current filesystem object group, updates $group property
     * on success.
     * For UNIX systems.
     *
     * @param mixed $group New group name or ID
     * @return File|null Current CFile object on success, 'false' on fail.
     */
    public function setGroup(mixed $group): ?self
    {
        if ($this->getExists() && chgrp($this->realpath, $group)) {
            $this->group = $group;
            return $this;
        }

        $this->addLog('Unable to set group for filesystem object to "' . $group . '"');
        return null;
    }

    /**
     * Sets the current filesystem object permissions, updates $permissions
     * property on success.
     * For UNIX systems.
     *
     * @param string $permissions New filesystem object permissions in numeric
     * (octal, i.e. '0755') format
     * @return File|null Current CFile object on success, 'false' on fail.
     */
    public function setPermissions(string $permissions): ?self
    {
        if ($this->getExists() && is_numeric($permissions)) {
            // '755' normalize to octal '0755'
            $permissions = octdec(str_pad($permissions, 4, '0', STR_PAD_LEFT));

            if (@chmod($this->realpath, $permissions)) {
                $this->group = $permissions;
                return $this;
            }
        }

        $this->addLog('Unable to change permissions for filesystem object to "' . $permissions . '"');
        return null;
    }

    /**
     * Resolves destination path for the current filesystem object.
     * This method enables short calls for {@link copy} & {@link rename} methods
     * (i.e. copy('mynewfile.htm') makes a copy of the current filesystem object
     * in the same directory, named 'mynewfile.htm')
     *
     * @param string $fileDest Destination filesystem object name
     * (with or w/o path) submitted by user
     * @return string Resolved real destination path for the current filesystem
     * object
     */
    private function resolveDestPath(string $fileDest): string
    {
        if (strpos($fileDest, DIRECTORY_SEPARATOR) === false) {
            return $this->getDirname() . DIRECTORY_SEPARATOR . $fileDest;
        }

        return $this->realPath($fileDest);
    }

    /**
     * Copies the current filesystem object to specified destination.
     * Destination path supplied by user resolved to real destination path with
     * {@link resolveDestPath}
     *
     * @param string $fileDest Destination path for the current filesystem
     * object to be copied to
     * @return File|null New CFile object for newly created filesystem object on
     * success, 'false' on fail.
     */
    public function copy(string $fileDest): ?self
    {
        $destRealPath = $this->resolveDestPath($fileDest);

        if ($this->getIsFile()) {
            if ($this->getReadable() && @copy($this->realpath, $destRealPath)) {
                return $this->set($destRealPath);
            }
        } else {
            Yii::debug('Copying directory "' . $this->realpath . '" to "' . $destRealPath . '"', 'ext.file');
            $dirContents = $this->dirContents($this->realpath, true);
            foreach ($dirContents as $item) {
                $itemDest = $destRealPath . str_replace($this->realpath, '', $item);

                if (is_file($item)) {
                    @copy($item, $itemDest);
                } elseif (is_dir($item)) {
                    $this->createDir(0754, $itemDest);
                }
            }

            return $this->set($destRealPath);
        }

        $this->addLog('Unable to copy filesystem object into "' . $destRealPath . '"');
        return null;
    }

    /**
     * Renames/moves the current filesystem object to specified destination.
     * Destination path supplied by user resolved to real destination path with
     * {@link resolveDestPath}
     *
     * @param string $fileDest Destination path for the current filesystem
     * object to be renamed/moved to
     * @return File|null Updated current CFile object on success, 'false' on fail.
     */
    public function rename(string $fileDest): ?self
    {
        $destRealPath = $this->resolveDestPath($fileDest);

        if ($this->getWriteable() && @rename($this->realpath, $destRealPath)) {
            $this->filepath = $fileDest;
            $this->realpath = $destRealPath;
            // update pathinfo properties
            $this->pathInfo();
            return $this;
        }

        $this->addLog('Unable to rename/move filesystem object into "' . $destRealPath . '"');
        return null;
    }

    /**
     * Slug for {@link rename}
     * @param $fileDest
     * @return mixed
     */
    public function move($fileDest): ?self
    {
        return $this->rename($fileDest);
    }

    /**
     * Purges (makes empty) the current filesystem object.
     * If the current filesystem object is a file its contents set to ''.
     * If the current filesystem object is a directory all its descendants are
     * deleted.
     *
     * @param null $path
     * @return mixed Current CFile object on success, 'false' on fail.
     */
    public function purge($path = null): ?self
    {
        if (!$path) {
            $path = $this->realpath;
        }

        if ($this->getIsFile()) {
            if ($this->getWriteable()) {
                return $this->setContents('');
            }
        } else {
            Yii::debug('Purging directory "' . $path . '"', 'ext.file');
            $dirContents = $this->dirContents($path, true);
            foreach ($dirContents as $item) {
                if (is_file($item)) {
                    @unlink($item);
                } elseif (is_dir($item)) {
                    $this->purge($item);
                    @rmdir($item);
                }
            }

            // @todo hey, still need a valid check here
            return $this;
        }
        return null;
    }

    /**
     * Deletes the current filesystem object.
     * For folders purge parameter can be supplied.
     *
     * @param boolean $purge If 'true' folder would be deleted with all the
     * descendants
     * @return boolean 'True' if sucessfully deleted, 'false' on fail
     */
    public function delete($purge = true): bool
    {
        if ($this->getWriteable()) {
            if (
                ($this->getIsFile() && @unlink($this->realpath)) ||
                (!$this->getIsFile() && ($purge ? $this->purge() : true) && rmdir($this->realpath))
            ) {
                $this->exists = $this->readable = $this->writeable = false;
                return true;
            }
        }

        $this->addLog('Unable to delete filesystem object');
        return false;
    }

    /**
     * Sends the current file to browser as a download with real or faked
     * file name.
     * Browser caching is prevented.
     * This method works only for files.
     *
     * @param bool $fakeName New filename (eg. 'myfileFakedName.htm')
     * @param boolean $serverHandled Whether file contents delivery is handled
     * by server internals (cf. when file contents is read and sent by php).
     * E.g.: lighttpd and Apache with mod-sendfile can use X-Senfile header to
     * speed up file delivery blazingly.
     * Note: If you want to serve big or even huge files you are definetly
     * advised to turn this option on and setup your server software
     * appropriately, if not to say that it is your only alternative :).
     * @return bool File download
     */
    public function send($fakeName = false, $serverHandled = false): bool
    {
        if ($this->getIsFile()) {
            if ($this->getReadable() && !headers_sent()) {
                $content_type = $this->getMimeType();

                if (!$content_type) {
                    $content_type = 'application/octet-stream';
                }

                if ($fakeName) {
                    $filename = $fakeName;
                } else {
                    $filename = $this->getBasename();
                }

                // disable browser caching
                header('Cache-control: private');
                header('Pragma: private');
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

                header('Content-Type: ' . $content_type);
                header('Content-Transfer-Encoding: binary');
                header('Content-Length: ' . $this->getSize(false));
                header('Content-Disposition: attachment;filename="' . $filename . '"');

                if ($serverHandled) {
                    header('X-Sendfile: ' . $this->realpath);
                } else {
                    if ($contents = $this->getContents()) {
                        echo $contents;
                    }
                }
                exit;
            }

            $this->addLog('Unable to prepare file for download. Headers already sent or file doesn\'t not exist');
            return false;
        }
        $this->addLog('send() and download() methods are available only for files', 'warning');
        return false;
    }

    /**
     * Slug for {@link send}
     * @param bool $fakeName
     * @param bool $serverHandled
     * @return bool
     */
    public function download($fakeName = false, $serverHandled = false): bool
    {
        return $this->send($fakeName, $serverHandled);
    }

    // Modified methods taken from Yii CFileHelper.php are listed below
    // ===================================================

    /**
     * Returns the MIME type of the current file.
     * If $mimeType property is set, returned value is read from that property.
     *
     * This method will attempt the following approaches in order:
     * <ol>
     * <li>finfo</li>
     * <li>mime_content_type</li>
     * <li>{@link getMimeTypeByExtension}</li>
     * </ol>
     *
     * This method works only for files.
     * @return mixed the MIME type on success, 'false' on fail.
     */
    public function getMimeType(): ?string
    {
        if ($this->mimeType) {
            return $this->mimeType;
        }

        if ($this->getIsFile()) {
            if ($this->getReadable()) {
                if ($this->isUploaded) {
                    return $this->mimeType = $this->uploadedInstance->type;
                }

                if (function_exists('finfo_open')) {
                    if (
                        ($info = @finfo_open(FILEINFO_MIME)) &&
                        ($result = finfo_file($info, $this->realpath)) !== false
                    ) {
                        return $this->mimeType = $result;
                    }
                }

                if (function_exists('mime_content_type') && ($result = @mime_content_type($this->realpath)) !== false) {
                    return $this->mimeType = $result;
                }

                return $this->mimeType = $this->getMimeTypeByExtension();
            }

            $this->addLog('Unable to get mime type for file');
            return null;
        }

        $this->addLog('getMimeType() method is available only for files', 'warning');
        return null;
    }

    /**
     * Determines the MIME type based on the extension of the current file.
     * This method will use a local map between extension name and MIME type.
     * This method works only for files.
     *
     * @return string the MIME type. False is returned if the MIME type cannot
     * be determined.
     */
    public function getMimeTypeByExtension(): ?string
    {
        if ($this->getIsFile()) {
            Yii::debug(
                'Trying to get MIME type for "' . $this->realpath . '" from extension "' . $this->extension . '"',
                'ext.file'
            );
            static $extensions;
            if ($extensions === null) {
                $extensions = require Yii::getSlug(FileHelper::$mimeMagicFile);
            }

            $ext = strtolower($this->extension);
            if (!empty($ext) && isset($extensions[$ext])) {
                return $extensions[$ext];
            }

            return null;
        }

        $this->addLog(__METHOD__ . ' method is available only for files', 'warning');
        return null;
    }
}
