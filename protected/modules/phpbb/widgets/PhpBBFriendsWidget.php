<?php
/**
 * PhpBBFriendsWidget
 *
 * <pre>
 * <?php $this->widget('phpbb.widgets.PhpBBFriendsWidget', array('user'=>$model)); ?>
 * </pre>
 *
 * @author ElisDN <mail@elisdn.ru>
 * @link http://www.elisdn.ru
 * @version 1.0
 */

class PhpBBFriendsWidget extends CWidget
{
    public $tpl = 'default';
    public $class = 'friends';

    public $user;

    public function run()
    {
        $friends = $this->user->phpBbUser->friends;

        $this->render('PhpBBFriends/' . $this->tpl, array(
            'friends'=>$friends,
            'user'=>$this->user,
            'class'=>$this->class,
        ));
    }
}
