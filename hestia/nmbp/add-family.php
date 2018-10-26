<?php
global $wpdb;
$iUserID = get_current_user_id();

// Get families where I am the HOH
$sSQL = "SELECT COUNT(f.id) AS 'family_count', f.name AS 'family_name', f.id as 'family_id'
        FROM wp_family_license l 
        LEFT JOIN wp_families f on l.family_id = f.id
        WHERE f.active = 1 AND f.hoh_id = {$iUserID} AND l.available = 1
        GROUP BY f.id;";
$aResults = $wpdb->get_results($sSQL);

$iLicensesAvailable = 0;
if (is_array($aResults) && isset($aResults[0]->family_count)) {
    $iLicensesAvailable = $aResults[0]->family_count;
}

if ($iLicensesAvailable > 0) :
    $aUsers = get_users();
    ?>
    <div class="row">
        <h2 class="text-center">You have <?php echo $iLicensesAvailable; ?> license(s) left for your family.</h2><br/>

        <form action="/my-family-submit/" method="post">

            <div class="form-group col-md-5">
                <h4 style="text-decoration:underline;">Add an existing user:</h4>

                <div class="row">

                    <div class="form-group col-md-12">
                        <label for="existing_user">Existing User:</label>
                        <select class="form-control" id="existing_user" name="existing_user">
                            <option value="0">Choose A User</option>
                            <?php foreach ($aUsers as $oUser) : ?>
                                <option value="<?php echo $oUser->data->ID; ?>"><?php echo $oUser->data->display_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="add_family_relationship">Family To Add To</label>
                        <select class="form-control" id="add_family_relationship" name="add_family_relationship">
                            <option value="0">Choose A Family</option>
                            <?php foreach ($aResults as $oResult) : ?>
                                <option value="<?php echo $oResult->family_id; ?>"><?php echo $oResult->family_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
            </div>

            <div class="col-md-2">
                <h2>- OR -</h2>
            </div>

            <div class="form-group col-md-5">
                <h4 style="text-decoration:underline;">Create a new user:</h4>

                <div class="row">
                    <div class="col-md-12">
                        <label for="add_family_username">Create Username</label>
                        <input type="text" class="form-control" id="add_family_username" name="add_family_username" placeholder="Enter name of the gift">
                    </div>
                    <div class="col-md-12">
                        <label for="add_family_email">Enter Valid Email</label>
                        <input type="text" class="form-control" id="add_family_email" name="add_family_email" placeholder="Enter name of the gift">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="add_family_relationship_new">Choose Family To Add To</label>
                        <select class="form-control" id="add_family_relationship_new" name="add_family_relationship_new">
                            <option value="0">Choose A Family</option>
                            <?php foreach ($aResults as $oResult) : ?>
                                <option value="<?php echo $oResult->family_id; ?>"><?php echo $oResult->family_name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
<?php else : ?>
    <div class="row">
        <div class="col-md-12">
            <p class="text-center">Sorry, but you either don't have access to this page or any more licenses...</p>
        </div>
    </div>
<?php endif; ?>


