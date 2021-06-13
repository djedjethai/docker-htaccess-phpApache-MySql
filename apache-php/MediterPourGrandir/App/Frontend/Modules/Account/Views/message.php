
	<div class="rowgrid">
		<?php if(!empty($messages)) {
				
		?>
		<table>
			<div class="paragraph">
		  	<thead><tr><th>Titre</th><th>Date d'ajout</th><th>Consulter</th></tr></thead>
			<?php
	
				foreach($messages as $message)
				{
					if($message->status()){
						$iconValid = '<i style="color: red;" class="far fa-check-circle fa-lg"></i>';
					} else {
						$iconValid = '<i style="color: blue;" class="far fa-check-circle fa-lg"></i>';
					}
	
				  echo '<tbody><tr><td>', $message->titleNews(), '</td><td>le ', $message->dateAjout(), '</td><td><a href="/news/news-', $message->idNews(), '.php">', $iconValid, '</a></td></tr></tbody>', "\n";
				}
			?>
		</table>
		<?php } else { ?>
			<div class="justify-center">
				<h1>Vous n'avez pas de message</h1>
			</div>
		<?php } ?>
		</div>
	</div>
</section>	


