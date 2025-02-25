<div class="col-md-6 col-lg-4 d-flex align-items-stretch">
    <div class="card w-100">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Account movements</h5>
            <p class="card-subtitle mb-7">All movements of credits on your account</p>
            <div class="position-relative">
                <?php

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/account-movements?whereRelation[relation][email]=' . $GLOBALS_USER_EMAIL . '&timestamps',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer hYNIyTLFG1eHQ2ap146I3ENmZ6Ct6OpsghpyySOB'
                    ),
                ));

                $response = curl_exec($curl);
                curl_close($curl);
                
                $movements = json_decode($response, true);
                
                function formatDateTime($published_at) {
                    $timestamp = strtotime($published_at);
                    $now = time();
                    $diff = $now - $timestamp;
                    
                    if ($diff < 0) {
                        // Wenn das Datum in der Zukunft liegt
                        if ($diff > -300) { // weniger als 5 Minuten
                            return "Just now";
                        } else if ($diff > -3600) { // weniger als 1 Stunde
                            return round(abs($diff) / 60) . " min ago";
                        } else if ($diff > -86400) { // weniger als 1 Tag
                            $hours = round(abs($diff) / 3600);
                            return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
                        } else if ($diff > -432000) { // weniger als 5 Tage
                            $days = round(abs($diff) / 86400);
                            return $days . " day" . ($days > 1 ? "s" : "") . " ago";
                        } else {
                            return date("m/d/Y", $timestamp);
                        }
                    } else {
                        // Wenn das Datum in der Vergangenheit liegt
                        if ($diff < 300) { // weniger als 5 Minuten
                            return "Just now";
                        } else if ($diff < 3600) { // weniger als 1 Stunde
                            return round($diff / 60) . " min ago";
                        } else if ($diff < 86400) { // weniger als 1 Tag
                            $hours = round($diff / 3600);
                            return $hours . " hour" . ($hours > 1 ? "s" : "") . " ago";
                        } else if ($diff < 432000) { // weniger als 5 Tage
                            $days = round($diff / 86400);
                            return $days . " day" . ($days > 1 ? "s" : "") . " ago";
                        } else {
                            return date("m/d/Y", $timestamp);
                        }
                    }
                }
                
                foreach($movements as $movement) {
                ?>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <div class="d-flex">
                            <div class="p-8 bg-success-subtle rounded-2 d-flex align-items-center justify-content-center me-6">
                                <img src="./app/plus.svg" alt="" class="img-fluid" width="24" height="24">
                            </div>
                            <div>
                                <h6 class="mb-1 fs-4 fw-semibold"><?php echo $movement['title']; ?></h6>
                                <p class="fs-3 mb-0"><?php echo formatDateTime($movement['published_at']); ?></p>
                            </div>
                        </div>
                        <h6 class="mb-0 fw-semibold"><?php echo ($movement['type'] === 'positive' ? '+' : '-') . $movement['quantity']; ?> Credits</h6>
                    </div>
                <?php
                }
                ?>
            </div>
            <a href="payment-history" class="btn btn-outline-primary w-100">View all Payments</a>
        </div>
    </div>
</div>