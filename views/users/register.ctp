<?php echo $this->element('header')?>
        <div class="container showgrid">
                <h1><?php echo __('Adress Social Contact'); ?></h1>
                <?php echo $this->Session->flash(); ?>
                <div class='span-8'>
                <?php echo $this->Form->create('User',array('url'=>array('controller'=>'users','action'=>'register')))?>
                    <?php
                        echo $this->Form->input('first_name', array(
                            'label' => __('First Name', true) . ':',
                            'div' => array(
                                'class' => ''
                            ),
                        'class' => 'text'
                        ));
                    ?> 
        
                    <?php
                        echo $this->Form->input('last_name', array(
                            'label' => __('Last Name', true) . ':',
                            'div' => array(
                                'class' => ''
                            ),
                        'class' => 'text'
                        ));
                    ?>  
                            
                    <?php                          
                        echo $this->Form->input('username', array(
                            'label' => __('User Name', true) . ':',
                            'div' => array(
                                'class' => ''
                            ),
                        'class' => 'text'
                        ));
                    ?>
                    <?php
                        echo $this->Form->input('email',array(
                            'label'=>__('User Email',true).':',
                            'div'=>true,
                            'class'=>'text'
                        ))
                    ?>
                    <?php
                        echo $this->Form->input('password', array(
                            'label' => __('Password', true) . ':',
                            'div' => array(
                                'class' => ''
                            ),
                            'class' => 'text'
                        ));
                    ?>             
                    <?php
                        echo $this->Form->input('confirm_password', array(
                            'type'=>'password',
                            'label' => __('Confirm Password', true) . ':',
                            'div' =>true,
                            'class' => 'text'
                        ));
                    ?>     
                <?php echo $this->Form->end('submit')?>
                <span class='span-3'><?php echo $this->Html->link(__('Forget Password',true),'#')?></span>
                <span class='span-3'><?php echo $this->Html->link(__('Login',true),'#')?></span>
             </div>

        </div>
<?php echo $this->element('footer')?>
