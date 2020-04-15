<?php
    $content = $data['Post']['content'];
    $postId = $data['Post']['id'];
    $postAgo = $data['Post']['post_ago'];
    $sharePic = $data['UserProfile']['image'];
    $gender = $data['UserProfile']['gender'];
    $fullName = $this->System->getFullNameById($data['User']['id']);
    $userId = $this->Session->read('Auth.User')['id'];
    $myPic = $this->System->getUserPic($userId);
?>
<div class="container">
    <div class='container border p-3 mb-3'>
        <div class='row'>
            <div class="col-sm-2">
                <img src='<?=$sharePic;?>'>
            </div>
            <div class="post-details col-sm-10">
                <div class="row">
                    <div class="post-user">
                        <?=$fullName?>
                    </div>
                    <div class="post-ago">
                        <?=$postAgo?>
                    </div>
                    <div class='post-content col-sm-12'>
                        <p>
                            <?=h($content)?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class="col-sm-2">
            <img src="<?=$myPic;?>">
        </div>
        <div class="col-sm-10">
        <?= $this->Form->create('Comment',
                                ['url' => ['controller' =>'comments', 'action' => 'add']],
                                ['inputDefaults'=> ['div' => 'form-group']]); ?>
        <?php
            echo $this->Form->input('content', array(
                                    'label' => false,
                                    'type' => 'text',
                                    'id' => 'content',
                                    'class' => 'mt-2 form-control ',
                                    'placeholder' => "Add Comment..."
            ));
            
            echo $this->Form->input('post_id', array(
                                    'label' => false,
                                    'type' => 'hidden',
                                    'value' => $postId,
                                    'id' => 'post_id'
            ));
        ?>
        <?= $this->Form->end(['label' => 'comment',
                                'class' => 'comment_post btn btn-primary form',
                                'div' => 'form-group mt-3',
                                'style' => 'float: right']); ?>
                                
        </div>
    </div>
</div>