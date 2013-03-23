<?php
/**
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.0
 */

/**
 * This is the model class for table "phpbb_users".
 *
 * The followings are the available columns in table 'phpbb_users':
 * @property integer $user_id
 * @property integer $user_type
 * @property integer $group_id
 * @property string $user_permissions
 * @property integer $user_perm_from
 * @property string $user_ip
 * @property string $user_regdate
 * @property string $username
 * @property string $username_clean
 * @property string $user_password
 * @property string $user_passchg
 * @property integer $user_pass_convert
 * @property string $user_email
 * @property string $user_email_hash
 * @property string $user_birthday
 * @property string $user_lastvisit
 * @property string $user_lastmark
 * @property string $user_lastpost_time
 * @property string $user_lastpage
 * @property string $user_last_confirm_key
 * @property string $user_last_search
 * @property integer $user_warnings
 * @property string $user_last_warning
 * @property integer $user_login_attempts
 * @property integer $user_inactive_reason
 * @property string $user_inactive_time
 * @property integer $user_posts
 * @property string $user_lang
 * @property string $user_timezone
 * @property integer $user_dst
 * @property string $user_dateformat
 * @property integer $user_style
 * @property integer $user_rank
 * @property string $user_colour
 * @property integer $user_new_privmsg
 * @property integer $user_unread_privmsg
 * @property string $user_last_privmsg
 * @property integer $user_message_rules
 * @property integer $user_full_folder
 * @property string $user_emailtime
 * @property integer $user_topic_show_days
 * @property string $user_topic_sortby_type
 * @property string $user_topic_sortby_dir
 * @property integer $user_post_show_days
 * @property string $user_post_sortby_type
 * @property string $user_post_sortby_dir
 * @property integer $user_notify
 * @property integer $user_notify_pm
 * @property integer $user_notify_type
 * @property integer $user_allow_pm
 * @property integer $user_allow_viewonline
 * @property integer $user_allow_viewemail
 * @property integer $user_allow_massemail
 * @property string $user_options
 * @property string $user_avatar
 * @property integer $user_avatar_type
 * @property integer $user_avatar_width
 * @property integer $user_avatar_height
 * @property string $user_sig
 * @property string $user_sig_bbcode_uid
 * @property string $user_sig_bbcode_bitfield
 * @property string $user_from
 * @property string $user_icq
 * @property string $user_aim
 * @property string $user_yim
 * @property string $user_msnm
 * @property string $user_jabber
 * @property string $user_website
 * @property string $user_occ
 * @property string $user_interests
 * @property string $user_actkey
 * @property string $user_newpasswd
 * @property string $user_form_salt
 * @property integer $user_new
 * @property integer $user_reminded
 * @property string $user_reminded_time
 *
 * @property User $user
 * @property PhpBBUser[] $friends
 */
class PhpBBUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PhpBBUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getDbConnection()
    {
        return Yii::app()->forumDb;
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{users}}';
	}

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user'=>array(self::HAS_ONE, 'User', array('username'=>'username')),
            'friends'=>array(self::MANY_MANY, 'PhpBBUser', '{{zebra}}(user_id, zebra_id)', 'condition'=>'friend=1'),
        );
    }

    /**
     * @param string $name
     * @return PhpBBUser the static model class
     */
    public function findByName($name)
    {
         return $this->findByAttributes(array('username'=>$name));
    }

    protected $_age;

    public function getAge()
    {
        if ($this->_age === null)
            $this->_age = $this->user_birthday && $this->user_birthday != '0- 0- 0' ? $this->calcAge($this->user_birthday) : 0;

        return $this->_age;
    }

    protected function calcAge($birthday)
    {
        list($d, $m, $y) = explode('-', $birthday);
        $m_age = date("Y") - $y - ((intval($m . $d) - intval(date("m") . date("d")) > 0) ? 1 : 0);
        return $m_age;
    }
}