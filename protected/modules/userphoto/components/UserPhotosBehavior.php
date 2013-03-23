<?php

class UserPhotosBehavior extends CActiveRecordBehavior
{
    public function afterDelete($event)
    {
        $userId = $event->sender->getPrimaryKey();

        if ($userId)
        {
            $photos = UserPhoto::model()->user($userId)->findAll();
            foreach ($photos as $photo)
                $photo->delete();
        }
    }
}
