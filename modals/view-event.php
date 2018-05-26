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
                <p id="toggle-route-container"><a href="#" id="toggle-route">[<span id="toggle-state"></span> ruta]</a></p>
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
                <div class="row feedback-votes">
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
                    <div class="clear"></div>
                    <?php }
                    else{ ?>
                    <!-- if user is not logged in display only the number of positive/negative votes -->
                    <div class="up-col" id="upvote-event">
                        <i class="fas fa-arrow-up"></i>
                        <span id="upvotes"><!-- number of positive votes goes here --></span>
                    </div>
                    <div class="down-col" id="downvote-event">
                        <i class="fas fa-arrow-down"></i>
                        <span id="downvotes"><!-- numer of negative votes goes here --></span>
                    </div>
                    <div class="clear"></div>
                    <?php } ?>
                </div>
                <div class="row fb-bar-container">
                    <div class="col12 fb-bar">
                        <div class="up-bar"></div>
                        <div class="down-bar"></div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="row">
            <p class="subtitle">Comentarii</p>
            <div id="comments-container" class="col12">
                <!-- comments go here -->
            </div>
        </div>
    </div>
</div>