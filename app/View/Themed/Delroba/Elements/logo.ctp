<div id="id">
	<h1>
        <?php
        echo $this->Html->link(
            $this->Html->image('logo.png', array('alt' => 'Logo')),
            '/',
            array('escape' => false, 'title' => 'Logo', 'rel' => 'home')
        );
        ?>
	</h1>			
</div>