	
	<?php  
	/*-------------------------------
	| Keyword Search Section
	|--------------------------------*/
	?>
	
	<?php echo $html->tag('h6',"Search",array('class'=>'adres-button small ui-state-default ui-corner-all')) ?>
	<hr class="space" />
	<?php echo $form->create('Search',array(
		'url'=>array(
			'controller'=>'users',
			'action'=>'add_keyword'
		),
		'type'=>'get',
		'class' => 'adres-ajax-search', 
		)) ?>
		
		<div class="text input">
			<?php echo $form->input('keyword',array(
				'class'=>'text span-3 ui-corner-all',
				'value'=>'', # can set the inital value
				'label'=>false,
				'div'=>false
			)) ?>
			<?php echo $form->hidden('contact_type_id',array(
				'value' => 5
			)); ?>
			
			<?php echo $form->end(array('label'=>'Search','class' => 'adres-button small')) ?>
		</div>

	<hr class="space" />
	<?php  
	/*-------------------------------
	| Advance Search Section
	|--------------------------------*/
	?>
	<?php echo $html->tag('h6',$html->link('Advance Search',array('#'),array(
			'id' => 'toggle-search', 
		)),
			array(
				#options of html->tag
				'class'=>'adres-button small ui-state-default ui-corner-all'
			)) ?>	
	<hr class="space" />
	
	<div id="adres-advance-search" style="display:none">
		<?php echo $form->create('AdvanceSearch',array(
			'url'=>array(
				'controller'=>'users',
				'action'=>'add_criteria'
			),
			'class' => 'adres-ajax-form'
			)) ?>
			<?php
			/*-------------------------------
			| Advance Search generated form 
			| the plugin
			|-------------------------------*/
			?>
			<?php echo $advance_search_form ?>
			
			
			<?php
			/*-------------------------------
			| Affiliation Search 
			|-------------------------------*/	?>	
			
		<?php echo $form->end(array('label'=>'Advance Search','class'=>'adres-button')) ?>
	
	</div>

	<?php  
	/*-------------------------------
	| Groups Filter Section
	|--------------------------------*/
	?>
	

	<?php if (isset($groups) and !empty($groups)): ?>

		<div id="adres-saved-group">
		<?php echo $html->tag('h6',__('Groups',true),array('class'=>'adres-button small ui-state-default ui-corner-all')) ?>		
			<div id="group-tree">
				<?php echo $tree->generate($groups,array(
					'model' => 'Group',
					'element'=>'group_link',
				)) ?>
			</div>
		</div><!-- adres-groups -->

	<?php endif ?>


	<hr class="space" />	
		

	<?php  
	/*-------------------------------
	| Keyword Filter Section
	|--------------------------------*/
	?>
	
	<?php if ($session->check('Filter.keyword') || $session->check('Filter.criteria')): ?>

		<?php echo $html->tag('h6',__('Loaded Filters',true),array('class'=>'adres-button small ui-state-default ui-corner-all')) ?>	
		
		<?php $keyword = $session->read('Filter.keyword') ?>

		<?php if ($session->check('Filter.keyword')): ?>
			<div class="adres-criteria">
				<?php echo $html->link("Keyword :{$keyword}",array(
					'controller'=>'users',
					'action' => 'delete_keyword', 
					$keyword
				),array(
					'class'=>'adres-ajax-anchor adres-delete-keyword'
				)) ?>				
			</div>
		<?php endif ?>

		<br>
		
		
	<?php  
	/*-------------------------------
	| Criteria Filter Section
	|--------------------------------*/
	?>
			

		
		<?php if ($session->check('Filter.criteria')): ?>
			<?php $criterias = unserialize($session->read('Filter.criteria')) ?>

			<?php echo "Criterias:" ?>
				
			<?php foreach ($criterias as $idx => $criteria): ?>
			<div class="adres-criteria">					
				<?php echo $html->link($criteria['name'],array(
					'controller'=>'users',
					'action'    =>'delete_criteria',
					'id:'.$idx
					),
					array(
					'class'=>'adres-ajax-anchor'	
					)
				) ?>
			</div>				
			<?php endforeach ?>
		<?php endif ?>
		
		<?php echo $form->create('Filter',array(
			'url'=>array(
				'controller'=>'users',
				'action' => 'save_filter'
			),
			'class' => 'adres-ajax-form adres-save-filter',
		)) ?>
			<?php echo $form->input('name',array(
				'class'=>'text ui-corner-all span-5',
				'lable'=>array('text'=>'Filter Name')
			)) ?>
		<?php echo $form->end(array('label'=>'save','class'=>'adres-button')) ?>
		
	<?php endif ?>	
	
	
	
	<?php  
	/*-------------------------------
	| Saved Filter Section
	|--------------------------------*/
	?>
			
	<div id="adres-saved-filters">

	<?php  echo $html->tag('h6',__('Filters',true),array('class'=>'adres-button small ui-state-default ui-corner-all')) ?>
		<div class="ajax-response">
			
		<?php 
			/*-------------------------------
			| Shows the filters list from same element
			|--------------------------------*/			
			echo $this->element('ajax/save_filter') 
		?>
		
		
		</div>	
	</div><!-- // adres-saved-filters -->	