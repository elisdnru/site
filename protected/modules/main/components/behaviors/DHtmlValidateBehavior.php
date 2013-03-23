<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 */

class DHtmlValidateBehavior extends CBehavior
{
    public function validateOutput($output)
    {
        $output = str_replace('<p></p>', '', $output);
        $output = str_replace('<p><p>', '<p>', $output);
        $output = str_replace('</p></p>', '</p>', $output);
        $output = str_replace('<p><ul', '<ul', $output);
        $output = str_replace('<p><div ', '<div ', $output);
        $output = str_replace('<p><div>', '<div>', $output);
        $output = str_replace('</div></p>', '</div>', $output);
        $output = str_replace('</ul></p></p>', '</ul>', $output);
        $output = str_replace('</ul></p>', '</ul>', $output);
        $output = str_replace("</ul>\r\n</p>", '</ul>', $output);
        $output = str_replace('</script></p>', '</script>', $output);
        $output = str_replace("</script>\r\n</p>", '</script>', $output);
        $output = str_replace('<br>', '<br />', $output);
        $output = str_replace('<hr>', '<hr />', $output);
        $output = str_replace('</p><br /></p>', '</p><br />', $output);
        $output = str_replace('<style>', '<style type="text/css">', $output);
        $output = str_replace('<script>', '<script type="text/javascript">', $output);
        return $output;
    }
}
