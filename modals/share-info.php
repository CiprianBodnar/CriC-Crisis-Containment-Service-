<div class="modal" id="share">
	<div class="box-small white">
		<form action="#" method="POST">
			<div class="row modal-title">
				<h3>
					Oferă informații despre o persoană
				</h3>
				<div class="modal-close">
					<i class="fas fa-times"></i>
				</div>
				<div class="clear"></div>
			</div>
			<div class="row">
				<div class="col12">
					<p>
						Introduceți numele
					</p>
					<input class="clearinput" name="Nume2" id="share-autocomplete" value="Nume" autocomplete="off" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
					<input autocomplete="off" type="hidden" name="suggested-user-id" id="share-suggested-user-id">
                    <div class="clear"></div>
				</div>
				<div id="share-users-suggest" class="search-users-suggest"></div>
			</div>
			<div class="row">
				<div class="col12">
					<p>
						Detalii
					</p>
					<textarea id="share-message" name="Mesaj"  onfocus="if(this.value=='Mesaj') this.value='';" onblur="if(this.value=='') this.value='Mesaj';" >Mesaj</textarea>
                    <div class="clear"></div>
				</div>
			</div>	
			<div class="row">
				<div class="col12">
					<p>
						Oferă o locație
						<input type="checkbox" name="checkbox" id="checkbox"> 
					</p>
					<input class="showthis" id="share-address-input" name="address"  >
					<input type="hidden" id="share-info-location">
                    <div class="clear"></div> 
                    <div class="index-send-button" id="share-info-submit">
						Trimite
					</div>
				</div>
			</div>	
		</form>
	</div>
</div>
