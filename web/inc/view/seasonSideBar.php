<?php
if (!isset($title)) {
    $title = 'Season Search';
}
?>
<div class="col-xs-2 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
    <div class="query">
        <form method="get" action="">
            <fieldset>
                <legend><?php echo $title ?></legend>
                <label for="lclubname">Club Name</label>
                <input type="text" id="clubname" name="clubname"
                       value="<?php echo getFormData('clubname'); ?>">
                <label for="season">Year</label>
                <select id="season" name="season" value="<?php echo getFormData('season'); ?>">
                    <option value=""></option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                </select>


                <input type="submit" value="Search">
            </fieldset>
        </form>
    </div>
</div>
<!--/.sidebar-offcanvas-->
