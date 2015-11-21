
<!-- /. NAV SIDE  -->
<div id="page-wrapper" >
    <div id="page-inner">
        <?php
        $this->table->set_heading('#1', '#2', '#3', '#4', '#5');
        $this->table->set_template(array(
            'table_open'  => '<table class="table table-hover">',
            'thead_open'  => '<thead>',
            'thead_close' => '</thead>',
        ));
        echo $this->table->generate($turnos);
        ?>
    </div>
</div>
