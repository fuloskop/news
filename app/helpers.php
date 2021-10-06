<?php

function getRoleTypeByUserId($id){
    $user = \App\Models\User::findOrFail($id);
    if($user->hasrole('admin')){
        return 'admin';
    }
    if($user->hasrole('moderator')){
        return 'moderator';
    }
    if($user->hasrole('editor')){
        return 'editor';
    }

    return 'user';
}
