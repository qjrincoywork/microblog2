<?php
    $content = $data['Post']['content'];
    $postId = $data['Post']['id'];
    $postAgo = $data['Post']['post_ago'];
    $profPic = $data['UserProfile']['image'];
    $userId = $this->Session->read('User')['id'];
    $fullName = $this->System->getFullNameById($userId);
?>
<div class="container p-3">
    <?= $this->Form->create('Post',
                            ['url' => ['controller' =>'posts', 'action' => 'edit']],
                            ['inputDefaults'=> ['div' => 'form-group']]); ?>
    <?php
        echo $this->Form->input('content', array(
                                'label' => false,
                                'id' => 'content',
                                'value' => $data['Post']['content'],
                                'class' => 'mb-3 form-control ',
                                'placeholder' => "Edit Content..."
        ));
        echo $this->Form->input('id', array(
                                'label' => false,
                                'type' => 'hidden',
                                'value' => $postId,
                                'id' => 'id'
        ));
    ?>
    <div class='container border p-3'>
        <div class='row'>
            <div class="col-sm-2">
                <img src='<?=$profPic;?>'>
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
                            <?=$content?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->end(['label' => 'edit post',
                            'class' => 'edit_post btn btn-primary',
                            'div' => 'form-group mt-3',
                            'style' => 'float: right']); ?>
</div>