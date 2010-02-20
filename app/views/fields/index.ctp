<div class="fields index">
<h2><?php __('Fields');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('name');?></th>
	<th><?php echo $paginator->sort('contact_type__id');?></th>
	<th><?php echo $paginator->sort('order');?></th>
	<th><?php echo $paginator->sort('field_type_class_name');?></th>
	<th><?php echo $paginator->sort('is_descriptive');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($fields as $field):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $field['Field']['id']; ?>
		</td>
		<td>
			<?php echo $field['Field']['name']; ?>
		</td>
		<td>
			<?php echo $field['Field']['contact_type__id']; ?>
		</td>
		<td>
			<?php echo $field['Field']['order']; ?>
		</td>
		<td>
			<?php echo $field['Field']['field_type_class_name']; ?>
		</td>
		<td>
			<?php echo $field['Field']['is_descriptive']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action' => 'view', $field['Field']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action' => 'edit', $field['Field']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action' => 'delete', $field['Field']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $field['Field']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Field', true), array('action' => 'add')); ?></li>
	</ul>
</div>
