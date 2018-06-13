<div class="modal" id="view-event">  
    <div class="box-small white">
        <div class="preloader"><i class="fas fa-spinner fa-spin"></i></div>
        <!-- hidden inputs -->
        <input type="hidden" id="event-id" name="event-id">
        <div class="row modal-title"> 
            <h3 id="event-title"><!-- event title goes here --></h3>
            <span id="remove-event">[șterge]</span>
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
            <div class="col6" id="event-range-container">
                <p class="subtitle">Raza evenimentului</p>
                <p class="event-content" id="event-range"><!-- Event range goes here --></p>
            </div>
            <div class="col6" id="event-votes-container">
                <div class="row feedback-votes">
                    <input type="hidden" name="feedback_val" id="feedback-val">
                     <!-- if user is logged in display upvote/downvote buttons -->
                    <?php if($loggedIn === true){ ?>
                    <button class="up-col" id="upvote-event">
                        <i class="fas fa-arrow-up"></i>
                        <span id="upvotes"><!-- number of positive votes goes here --></span>
                    </button>
                    <button class="down-col" id="downvote-event">
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
        <div class="row" id="event-poster-container">
            <div class="col12">
                <p class="subtitle">Adăugat de</p>
                <div id="poster-container">
                    <div class="poster-name-container">
                        <span class="poster-name">
                            <!-- poster name goes here -->
                        </span>
                        <span class="post-date">
                            <!-- post datetime goes here -->
                        </span>
                    </div>
                    <div id="poster-address" class="poster-address"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <p class="subtitle">Comentarii</p>
            <div id="comments-container" class="col12">
                <!-- comments go here -->
            </div>
            <?php if ($loggedIn === true){ ?>
            <form id="add-comment" class="col12">
                <div class="col1">
                    <div id="user-av-container" class="av-container">
                        <?php 
                            $words = explode(" ", $_SESSION['name']);
                            echo $words[0][0].$words[1][0];
                         ?>
                    </div>
                </div>
                <div class="col10 right-side">
                    <textarea name="comment-content" id="comment-content"></textarea>
                </div>
                <div class="col1">
                    <div id="add-comment-button"><i class="fas fa-paper-plane"></i></div>
                </div>
                <div class="clear"></div>
            </form>
            
            <?php } ?>
        </div>
    </div>
</div>