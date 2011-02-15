<div class="affiliations">
	<?php echo $this->element('affiliations/_form'); ?>
</div>
<div class="add_action">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action' => 'delete', $form->value('Affiliation.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Affiliation.id'))); ?></li>
		<li><?php echo $html->link(__('List Affiliations', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Contact Types', true), array('controller' => 'contact_types', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Father Contact Type', true), array('controller' => 'contact_types', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Contacts', true), array('controller' => 'contacts', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Contact', true), array('controller' => 'contacts', 'action' => 'add')); ?> </li>
	</ul>
	<div class="clear"></div>
</div>
