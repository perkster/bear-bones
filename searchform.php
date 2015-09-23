<div class="search-box">
<?php $search_text = ""; ?> 
<form method="get" id="searchform" action="<?php echo get_home_url(); ?>/" class="search-form"> 
	<div class="searchform-input-wrapper">
		<span class="infield-label">
		<label for="search" >Search</label>
		<input type="text" class="searchform__input" value="<?php echo $search_text; ?>"  name="s" id="search"  onblur="if (this.value == '') {this.value = '<?php echo $search_text; ?>';}"  onfocus="if (this.value == '<?php echo $search_text; ?>')  {this.value = '';}" />
		</span>
	</div>
	<input type="hidden" id="searchsubmit" /> 
</form>

</div>