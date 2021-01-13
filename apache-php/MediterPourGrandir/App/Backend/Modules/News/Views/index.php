<p style="text-align: center">Il y a actuellement <?= $nombreNews ?> news. En voici la liste :</p>

<div class="table-responsive">
	<table class="table table-hover">
	  <thead><tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Dernière modification</th><th>Action</th></tr></thead>
<?php
foreach ($listeNews as $news)
{
  echo '<tbody><tr><td>', $news['auteur'], '</td><td><a href="news-', $news['id'], '.html">', $news['titre'], '</a></td><td>le ', $news['dateAjout']->format('d/m/Y à H\hi'), '</td><td>', ($news['dateAjout'] == $news['dateModif'] ? '-' : 'le '.$news['dateModif']->format('d/m/Y à H\hi')), '</td><td><a href="news-update-', $news['id'], '.html"><img src="/images/update.png" alt="Modifier" /></a> <a href="news-delete-', $news['id'], '.html"><img src="/images/delete.png" alt="Supprimer" /></a></td></tr></tbody>', "\n";
	}
	?>
	</table>
</div>


