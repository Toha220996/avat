<?php
	$brands = get_terms( 'brand', array('hide_empty' => false, 'parent'  => 0));
	$models = get_terms( 'model', array('hide_empty' => false, 'parent'  => 0));
	$type_works = get_terms( 'type_work', array('hide_empty' => false, 'parent'  => 0));
?>
<div class="content">
	<div id="jquery-accordion-menu" class="jquery-accordion-menu">
		<ul id="list-portfolio">
			<li class="li-projects"><a href="<?php echo (get_home_url() . '/portfolio/');?>"><i class="fa fa-bars"></i>Все работы</a></li>
			<li class="li-brand-sort <?php if(get_query_var('taxonomy') == 'brand') echo "active";?>"><a href="javascript:;" class="<?php if(get_query_var('taxonomy') == 'brand') echo "submenu-indicator-minus";?>" OnClick = "return false;" style="font-weight: 700;"><i class="fa fa-car"></i>По маркам:</a>
				<ul class="submenu" style="display: <?php if(get_query_var('taxonomy') == 'brand') echo "block";?>">
					<?php	
					if($brands) {
						foreach ($brands as $brand) {
					?>
					<li class="li-brand brand-<?php echo $brand->slug;?> <?php if($brand->slug == get_query_var('brand')) echo "active";?>">
						<a href="javascript:;" OnClick = "return false;"><?php echo $brand->name;?></a>
						<ul class="submenu" style="display: <?php if($brand->slug == get_query_var('brand')) echo "block";?>">	
							<li class="all-<?php echo $brand->slug;?> <?php if(!get_query_var('model')) echo "active";?>">
								<a href="<?php echo (get_home_url() . '/portfolio/' . $brand->slug . '/');?>">Все <?php echo $brand->name;?></a><span class="jquery-accordion-menu-label"><?php echo $brand->count;?></span>
							</li>
							<?php
							foreach ($models as $model) {
								if($brand->slug == get_term_meta($model->term_id , 'brand' , true ) && $model->count > 0){
							?>
							<li class="li-model model-<?php echo $model->slug;?> <?php if($model->slug == get_query_var('model')) echo " active";?>">
								<a href="<?php echo (get_home_url() . '/portfolio/' . $brand->slug . '/' . $model->slug . '/'); ?>"><?php echo $model->name; ?></a>
							</li>
							<?php
								}
							}
							?>
						</ul><!-- .submenu -->
					</li><!-- .li-brand -->
					<?php	
						}
					}
					?>
				</ul><!-- .submenu -->
			</li><!-- li-brand-sort -->
			<li class="li-type-work-sort" <?php if(is_tax() == 'type_work') echo "active";?>><a href="javascript:;" class="<?php if(get_query_var('taxonomy') == 'type_work') echo "submenu-indicator-minus";?> OnClick = "return false;" style="font-weight: 700;"><i class="fa fa-briefcase"></i>По виду работы:</a>
				<ul class="submenu" style="display: <?php if(get_query_var('taxonomy') == 'type_work') echo "block";?>">
					<?php
					if($type_works) {
						foreach ($type_works as $type_work) {
					?>
					<li class="type-<?php echo $type_work->slug;?> <?php if($type_work->slug == get_query_var('type_work')) echo " active";?>">
						<a href="<?php echo (get_home_url() . '/portfolio/type-work/' . $type_work->slug . '/'); ?>"><?php echo $type_work->name;?></a>
					</li>
					<?php
						}
					}
					?>
				</ul>
			</li>
		</ul><!-- #list-portfolio -->	
	</div><!-- #jquery-accordion-menu -->	
</div><!-- .content -->	









