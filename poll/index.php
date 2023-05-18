<?php
$polls = json_decode(file_get_contents('polls.json'), true);
$archivedPolls;
$activePolls;
if(!empty($polls)){
    foreach($polls as $poll){
        if($poll['deadline']>=date("Y-m-d")){
            $activePolls[] = $poll;
        }else{
            $archivedPolls[] = $poll;
        }
    }
    if(!empty($activePolls)){
    usort($activePolls, 'sortByDate');
    }
    if(!empty($archivedPolls)){
        usort($archivedPolls,'sortByDate');
    }
}

function sortByDate($a, $b){
    return strtotime($a['createdAt'])-strtotime($b['createdAt']);
}
//array_reverse($activePolls,true);

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
    <h1>Create Polls!</h1>
    <span>On this page you can create and post your polls</span>
    <form action="pollcreation.php" novalidate>
        <button>Create a poll!</button>
    </form>
    <?php if(!empty($polls)):?>
        <h2>Active polls</h2>
        <?php if(!empty($activePolls)):?>
        <?php foreach(array_reverse($activePolls) as $poll):?>
                <div class="poll-div">
                    ID: <?=$poll['id']?><br>
                    Question : <?=$poll['question']?><br>
                    Creation date: <?=$poll['createdAt']?><br>
                    Deadline: <?=$poll['deadline']?><br>
                    <form action="poll.php" method="get" novalidate>
                        <input type="hidden" name="id" value="<?=$poll['id']?>" /> 
                        <input type="submit" value="Vote!" class="button-28">
                    </form>
                </div>
        <?php endforeach ?>
        <?php endif ?>
        <?php if(!empty($archivedPolls)): ?>
            <h3>Archived polls</h3>
            <?php foreach(array_reverse($archivedPolls) as $poll): ?>
                    <div class="poll-div-archived">
                        ID: <?=$poll['id']?><br>
                        <?=$poll['createdAt']?><br>
                        <?=$poll['deadline']?><br>
                        Results : <?php foreach($poll['answers'] as $answer => $votes):?>
                            <?=$answer?> : <?=$votes?><br>
                            <?php endforeach ?>
                    </div>
            <?php endforeach ?>
        <?php endif ?>
    <?php endif ?>
</body>
</html>