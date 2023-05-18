<?php
    $polls = json_decode(file_get_contents('polls.json'), true);
    $id;
    if($_POST){
        if(empty($polls)){
            $id = 1;
        }else{
            $id= intval(end($polls)['id'])+1;
        }
        $options = explode("\r",$_POST['options']);
        $answers;
        foreach($options as $option){
            $answers[trim($option)] = 0;
        }
        if(isset($_POST['isMultiple'])){
            $data = [
                'id' => $id,
                'question' => $_POST['question'],
                'options' => $options,
                'isMultiple' => $_POST['isMultiple'],
                'createdAt' => date("Y-m-d"),
                'deadline' => $_POST['deadline'],
                'answers' => $answers,
                'voted' => []
            ];
            $polls[] = $data;
            file_put_contents('polls.json', json_encode($polls, JSON_PRETTY_PRINT));
            header('Location:index.php');
        }

        
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <h1>Create you own poll here!</h1>
    <div class="pollcreation">
    <form action="" method="post" novalidate>
        <input type="text" name="question" placeholder="Your question towards users" class = "pollcreation-text"><br>
        <textarea name="options" placeholder="Chooseable options" class="pollcreation-textarea"></textarea><br>
        Is it a multiply answerable question?<br>
        <input type="radio" name="isMultiple" value="true">Yes<br>
        <input type="radio" name="isMultiple" value="false">No<br>
        <input type="date" name="deadline"><br>
        <input type="submit" value="Submit!" class ="button-28">
    </form>
</body>
</html>