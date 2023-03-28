<?php
header("Access-Control-Allow-Origin: *");

use App\Middleware\CORSMiddleware;

class APIController extends ControllerBase
{

    public function indexAction()
    {
        
        //Show task list
        $task = Tasks::query()->execute();

        return json_encode($task);
        exit();
    }

    public function createAction()
    {

        $task = new Tasks();
        $task->assign(
            $_POST,
            [
                'description'
            ]
        );
        $result = $task->save();
        if (false === $result) {
            $messages = $task->getMessages();
            return json_encode(array("statusCode"=>400, "message"=>"Error", "data"=>$messages));
            exit();
        } else {
            return json_encode(array("statusCode"=>200, "message"=>"Success Task Created", "data"=>$task));
            exit();
        }
    }

    public function updateAction()
    {
        $task = Tasks::findFirst('id = '.$_POST['id']);
        $task->assign(
            $_POST,
            [
                'description'
            ]
        );
        $result = $task->save();
        if (false === $result) {
            $messages = $task->getMessages();
            return json_encode(array("statusCode"=>400, "message"=>"Error", "data"=>$messages));
            exit();
        } else {
            return json_encode(array("statusCode"=>200, "message"=>"Success Task Updated", "data"=>$task));
            exit();
        }
    }
    public function doneAction()
    {
        $task = Tasks::findFirst('id = '.$_POST['id']);
        if ($_POST['done'] == 1) {
            $done = 0;
        } else {
            $done = 1;
        }
        $task->assign(
            [
                'done' => $done
            ]
        );
        $result = $task->save();
        if (false === $result) {
            $messages = $task->getMessages();
            return json_encode(array("statusCode"=>400, "message"=>"Error", "data"=>$messages));
            exit();
        } else {
            return json_encode(array("statusCode"=>200, "message"=>"Success Task Updated", "data"=>$task));
            exit();
        }
    }
    public function deleteAction()
    {
        $task = Tasks::findFirst('id = '.$_POST['id']);
        $result = $task->delete();
        if (false === $result) {
            $messages = $task->getMessages();
            return json_encode(array("statusCode"=>400, "message"=>"Error", "data"=>$messages));
            exit();
        } else {
            return json_encode(array("statusCode"=>200, "message"=>"Success Task Deleted", "data"=>$task));
            exit();
        }
    }
}

