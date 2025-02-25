<div class="col-md-12 col-lg-8 d-flex align-items-stretch">
    <div class="card w-100">
        <div class="card-body">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-3">
                <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">SMS History</h5>
                    <p class="card-subtitle">Here you can see the last two SMS</p>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-middle text-nowrap mb-0">
                    <thead>
                        <tr class="text-muted fw-semibold">
                            <th scope="col" class="ps-0">To</th>
                            <th scope="col" class="ps-0">From</th>
                            <th scope="col">Status</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody class="border-top">
                        <tr>

                            <?php


                            $curl = curl_init();

                            curl_setopt_array($curl, array(
                                CURLOPT_URL => 'https://db.sanona.org/api/b872c5a521a44cc0983443494237e81e/sms-send?whereRelation[sender][email]=' . $GLOBALS_USER_EMAIL . '&sort=created_at%3ADESC&limit=5&timestamps=null',
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
                            // echo $response;
                            // Konvertiere die JSON-Antwort in ein PHP-Array
                            $data = json_decode($response, true);

                            // Time formatting function - define outside the loop
                            function formatTimeAgo($published_at)
                            {
                                $timestamp = strtotime($published_at);
                                $now = time();
                                $diff = $now - $timestamp;

                                if ($diff < 60) {
                                    return $diff . " seconds ago";
                                } elseif ($diff < 3600) {
                                    return floor($diff / 60) . " minutes ago";
                                } elseif ($diff < 7200) {
                                    return "1 hour ago";
                                } elseif ($diff < 86400) {
                                    return floor($diff / 3600) . " hours ago";
                                } elseif ($diff < 129600) { // 36 hours
                                    return "yesterday";
                                } else {
                                    return date("H:i d.m.Y", $timestamp);
                                }
                            }

                            if (count($data) > 0) {
                                // Verarbeitung jedes Datensatzes
                                foreach ($data as $sms) {
                                    $id = $sms['id'];
                                    $locale = $sms['locale'];
                                    $published_at = $sms['published_at'];
                                    $formatted_time = formatTimeAgo($published_at);

                                    $sms_from = $sms['sms_from'];
                                    $sms_to = $sms['sms_to'];
                                    $sms_message = $sms['sms_message'];
                                    $sms_network = $sms['sms_network'];
                                    $carrier_status = $sms['carrier_status'];
                                    $sms_network_gateway = $sms['sms_network_gateway'];
                                    $sms_message_id = $sms['sms_message_id'];
                                    $sms_message_price = $sms['sms_message_price'];
                                    $sender_id = $sms['sender']['id'];
                                    $sender_locale = $sms['sender']['locale'];
                                    $email = $sms['sender']['email'];
                                    $username = $sms['sender']['username'];
                                    $password = $sms['sender']['password'];
                                    $name = $sms['sender']['name'];
                                    $surname = $sms['sender']['surname'];
                                    $street = $sms['sender']['street'];
                                    $number = $sms['sender']['number'];
                                    $zip_code = $sms['sender']['zip-code'];
                                    $city = $sms['sender']['city'];
                                    $country = $sms['sender']['country'];
                                    $can_login = $sms['sender']['can-login'];
                                    $reason = $sms['sender']['reason'];
                                    $sms_contingent = $sms['sender']['sms_contingent'];
                                    $own_sender = $sms['sender']['own-sender'];
                                    $rank = $sms['sender']['rank'];
                                    $api_key = $sms['sender']['api_key'];
                                    $api_secret = $sms['sender']['api_secret'];
                                    $sender_cost = $sms['sender_cost'];
                                    $sender_ip = $sms['sender_ip'];
                                    $sender_system = $sms['sender_system'];
                                    $sender_gateway = $sms['sender_gateway'];

                                    // Hier kannst du mit den Variablen arbeiten, z.B. sie ausgeben oder in einer Datenbank speichern
                                    echo "<tr>
                              <td>$sms_to</td>
                              <td>$sms_from</td>
                              <td>$carrier_status</td>
                              <td>-$sender_cost</td>
                              <td>$formatted_time</td>
                              
                            </tr>";
                                }
                            } else {
                                echo "<tr>
                                    <td></td>
                                    <td></td>
                                    <td>No SMS sent found...</td>
                                    <td></td>
                                    <td></td>
                                    
                                  </tr>";
                            }




                            ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>