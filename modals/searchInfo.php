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
							<input type="text" id="search-autocomplete" autocomplete="off" name="Nume" value="Nume" onfocus="if(this.value=='Nume') this.value='';" onblur="if(this.value=='') this.value='Nume';">
							<div id="search-users-suggest"></div>
							<input type="hidden" name="suggested-user-id" id="search-suggested-user-id">
							<div id="search-info">
								<div id="posted-search-info"></div>
								<div id="user-search-info"></div>
							</div>
							<div id="submit-button" name="cauta">
	                            <i class="fas fa-search"></i>
	                        </div>
	                        <div class="clear"></div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
