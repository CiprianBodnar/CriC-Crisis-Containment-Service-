<div class="modal" id="view-event">  
    <div class="box-small white">
        <!-- hidden inputs -->
        <input type="hidden" name="event-id">
        <div class="row modal-title"> 
            <h3 id="event-title"><!-- event title goes here --></h3>
            <div class="modal-close"> 
                <i class="fas fa-times"></i>
            </div>
            <div class="clear"></div>
        </div>
        <div class="row">
            <div class="col12">
                <span class="location-icon fl">
                    <i class="fas fa-map-marker"></i>
                </span>
                <p class="event-content" id="event-location"><!-- Event location goes here --></p>
            </div>
        </div>
        <div class="row">
            <div class="col12">
                <p class="subtitle">Descriere</p>
                <p class="event-content" id="event-description"><!-- Event description goes here --></p>
            </div>
        </div>
        <div class="row">
            <div class="col6">
                <p class="subtitle">Raza evenimentului</p>
                <p class="event-content" id="event-range"><!-- Event range goes here --></p>
            </div>
            <div class="col6">
                <div class="row">
                     <!-- if user is logged in display upvote/downvote buttons -->
                    <?php if($loggedIn === true){ ?>
                    <button class="up-col" id="upvote-event" onclick="upvote()">
                        <i class="fas fa-arrow-up"></i>
                        <span id="upvotes"><!-- number of positive votes goes here --></span>
                    </button>
                    <button class="down-col" id="downvote-event" onclick="downvote()">
                        <i class="fas fa-arrow-down"></i>
                        <span id="downvotes"><!-- numer of negative votes goes here --></span>
                    </button>
                    <?php }
                    else{ ?>
                    <!-- if user is not logged in display only the number of positive/negative votes -->
                    <span class="up-col" id="upvotes"></span>
                    <span class="down-col" id="downvotes"></span>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="fb-bar">
                        <div class="up-bar"></div>
                        <div class="down-bar"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>