<div class="modal" id="inDanger">
	<div class="box-small white">
		<form  method="POST">
			<div class="row modal-title">
				<h3>
					Detalii despre situatia dvs.
				</h3>
				<div class="modal-close">
					<i class="fas fa-times"></i>
				</div>
				<div class="clear"></div>
			</div>
			<div class="row">
				<div class="col12">
					<p>
						Detalii
					</p>

					<textarea id="inDangerMessageId" name="inDangerMessage"  onfocus="if(this.value=='Mesaj') this.value='';" onblur="if(this.value=='') this.value='Mesaj';" >Mesaj</textarea>
                    <div class="clear"></div>
				</div>
			</div>	
			<div class="row">
				<div class="col12">
					<p>
						Locatia dumneavoastra este: 
					</p>
					<input type="hidden" id="danger-location">
					<input class="showthis forceDisplay" id="address-input2" name="myAddress" autocomplete="off">
                    <div class="clear"></div> 
                    <div class="index-send-button" id="sendInDanger" >
						Trimite
					</div>
				</div>
			</div>	
		</form>
	</div>
</div>