<div class="modal" id="search">  
		 <div class="container"> 
			<div class="box-small white">
				<form action="#" method="POST">
					<div class="row modal-title"> 
						<h3>
							Caută pe cineva
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
							<input type="text" name="Nume" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';"> 
							<button type="submit" id="submit-button" name="cauta">
	                            <i class="fas fa-search"></i>
	                        </button>
	                        <div class="clear"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal" id="share">
		 <div class="container">
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
							<input class="clearinput" name="Nume2" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
	                        <div class="clear"></div>
						</div>
					</div>
					<div class="row">
						<div class="col12">
							<p>
								Detalii
							</p>

							<textarea  name="Mesaj"  onfocus="if(this.value=='Mesaj') this.value='';" onblur="if(this.value=='') this.value='Mesaj';" >Mesaj</textarea>
		                    <div class="clear"></div>
						</div>
					</div>	
					<div class="row">
						<div class="col12">
							<p>
								Oferă o locație
								<input type="checkbox" name="checkbox" id="checkbox"> 
							</p>
								<input class="showthis "  id="address-input" name="address"  >

		                    <div class="clear"></div> 
		                    <button id="index-send-button" type="submit" name="ofera">
								Trimite
							</button>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>
    <div class="modal" id="inDanger">
		 <div class="container">
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

							<textarea  name="inDangerMessage"  onfocus="if(this.value=='Mesaj') this.value='';" onblur="if(this.value=='') this.value='Mesaj';" >Mesaj</textarea>
		                    <div class="clear"></div>
						</div>
					</div>	
					<div class="row">
						<div class="col12">
							<p>
								Locatia dumneavoastra este: 
							</p>
							<span style="display: none;" id="hidden-address"> </span>
							<input class="showthis forceDisplay" id="address-input2" name="myAddress"   >
		                    <div class="clear"></div> 
		                    <button id="index-send-button" type="submit" name="situatiaMea">
								Trimite
							</button>
						</div>
					</div>	
				</form>
			</div>
		</div>
	</div>