<?php
$polls = json_decode(file_get_contents('polls.json'), true);
$id = $_GET['id'];
$choosenPoll;
$error="";

foreach($polls as $poll){
    if($poll['id'] == $_GET['id']){
        $choosenPoll = $poll;
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(!isset($_POST['answer'])){
        $error = "please choose an option";
    }
    
    
    if(isset($_POST['answer'])){
        foreach($polls as &$poll){
            if($poll['id'] == $choosenPoll['id']){
                $poll['answers'][$_POST['answer']] +=1;
            }
        }
        file_put_contents('polls.json', json_encode($polls, JSON_PRETTY_PRINT));
        header('Location: index.php');
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
    <div class="poll">
        <?=$choosenPoll['question']?><br>
        <form action="poll.php?id=<?=$id?>" method="post" novalidate>
            <?php foreach($choosenPoll['answers'] as $option => $value): ?>
                <input type="radio" name="answer" value="<?=$option?>"><?=$option?><br>
            <?php endforeach ?> 
            <input type="submit" value="Submit">
        </form>
        Deadline : <?= $choosenPoll['deadline']?><br>
        Created at : <?= $choosenPoll['createdAt']?><br>
    </div>
    <?php if($error!=""):?>
        <?= $error?>
    <?php endif ?>

</body>
</html>