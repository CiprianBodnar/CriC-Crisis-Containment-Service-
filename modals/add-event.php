<div class="modal" id="add-danger">  
    <div class="box-small white">
        <form method="post" id="add-danger-form">
            <div class="row modal-title"> 
                <h3>
                    Semnalează un pericol
                </h3>
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
                    <p id="location-from-coord"></p>
                    <p>
                        Descrieți pe scurt:
                    </p>
                    <textarea name="decription" id="event-desc"></textarea>
                    <p>
                        Selectați tipul de pericol:
                    </p>

                    <select name="danger-type" id="event-type">
                        <option selected disabled hidden>Tipul de pericol</option>
                        <option value="fire"><i class="fas fa-fire"></i> Incendiu</option>
                        <option value="flood"><i class="fas fa-tint"></i> Inundație</option>
                        <option value="earthquake"><i class="fas-fa-globe"></i> Cutremur</option>
                        <option value="snowstorm"><i class="fas fa-snowflake"></i> Furtuna de zăpadă</option>
                    </select>
                    <p>
                        Raza pericolului (m): 
                    </p>
                    <input type="number" name="event-radius" id="event-radius" value="500">
                    <input type="text" value="" id="lat-input" name="lat" style="display: none;">
                    <input type="text" value="" id="lng-input" name="lng" style="display: none;">
                    
                    <div class="g-recaptcha" data-sitekey="6LfQ2FcUAAAAAPhVJg7Na0RYI6ZDjovVc4aLM31g"></div>

                    <button type="submit" id="submit-button">
                        Trimite
                    </button>
                    <div class="clear"></div>
                </div>
            </div>
        </form>
    </div>
</div>