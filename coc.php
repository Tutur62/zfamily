<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
<?php
$clantag = "#20LQPLQUL";

$token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiIsImtpZCI6IjI4YTMxOGY3LTAwMDAtYTFlYi03ZmExLTJjNzQzM2M2Y2NhNSJ9.eyJpc3MiOiJzdXBlcmNlbGwiLCJhdWQiOiJzdXBlcmNlbGw6Z2FtZWFwaSIsImp0aSI6IjJlNGVmYzBlLWUwMTgtNDRiNi1hODhjLWE1NWZlNjcxYjc1ZSIsImlhdCI6MTUyOTQzNDgyMywic3ViIjoiZGV2ZWxvcGVyLzlmNDhlODM2LTI5ODQtNDlmMC02NWQ2LTViZWFhNDE1NzMyYSIsInNjb3BlcyI6WyJjbGFzaCJdLCJsaW1pdHMiOlt7InRpZXIiOiJkZXZlbG9wZXIvc2lsdmVyIiwidHlwZSI6InRocm90dGxpbmcifSx7ImNpZHJzIjpbIjEzOS45OS4xOTUuMjA0Il0sInR5cGUiOiJjbGllbnQifV19.7MAiuvxvs-uwKFoB51iD0vrOcxcTRiGlwaHJzc0lGJOPYJjQpsSLZNNycPZlglhCPSDx-mUKHfhYF5Za5MqV7w";

$url = "https://api.clashofclans.com/v1/clans/" . urlencode($clantag);

$ch = curl_init($url);

$headr = array();
$headr[] = "Accept: application/json";
$headr[] = "Authorization: Bearer ".$token;

curl_setopt($ch, CURLOPT_HTTPHEADER, $headr);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$res = curl_exec($ch);
$data = json_decode($res, true);
curl_close($ch);

if (isset($data["reason"])) {
  $errormsg = true;
}

$members = $data["memberList"];

?>
  <title><?php echo $data["name"]; ?></title>
</head>
<body>
<?php
  if (isset($errormsg)) {
    echo "<p>", "Failed: ", $data["reason"], " : ", isset($data["message"]) ? $data["message"] : "", "</p></body></html>";
    exit;
  }
?>
  <table border="1">
    <tr>
      <td rowspan="11">Clan level : <?php echo $data["clanLevel"]; ?><br/><img src="<?php echo $data["badgeUrls"]["medium"]; ?>" alt="<?php echo $data["name"]; ?>"/></td>
      <td><?php echo $data["name"]; ?></td><td><?php echo $data["tag"]; ?></td>
    </tr>
    <tr>
      <td><?php echo $data["description"]; ?></td>
    </tr>
    <tr>
      <td>Trophées de clan</td><td><?php echo $data["clanPoints"]; ?></td>
    </tr>
    <tr>
      <td>Guerre gagnées</td><td><?php echo $data["warWins"]; ?></td>
    </tr>
    <tr>
      <td>Guerre gagnées consécutive</td><td><?php echo $data["warWinStreak"]; ?></td>
    </tr>
    <tr>
      <td>Egalité</td><td><?php echo $data["warTies"]; ?></td>
    </tr>
    <tr>
      <td>Guerre perdu</td><td><?php echo $data["warLosses"]; ?></td>
    </tr>
    <tr>
      <td>Membre</td><td><?php echo $data["members"]; ?>/50</td>
    </tr>
    <tr>
      <td>Type</td><td><?php echo $data["type"]; ?></td>
    </tr>
    <tr>
      <td>Trophées requis</td><td><?php echo $data["requiredTrophies"]; ?></td>
    </tr>
    <tr>
      <td>Fréquence de guerre</td><td><?php echo $data["warFrequency"]; ?></td>
    </tr>
    <tr>
      <td>Localisation du clan</td><td><?php echo $data["location"]["name"]; ?></td>
    </tr>
  </table>
  <table border="1">
    <tr>
      <td>Classement</td>
      <td>Rang</td>
      <td>Niveau</td>
      <td>Nom</td>
      <td>Don</td>
      <td>Reçu</td>
      <td>Trophées</td>
    </tr>
<?php
  foreach ($members as $member) {
?>
    <tr>
      <td><?php echo $member["clanRank"]; ?></td>
      <td><img src="<?php echo $member["league"]["iconUrls"]["tiny"]; ?>" alt="<?php echo $member["league"]["name"]; ?>"/></td>
      <td><?php echo $member["expLevel"]; ?></td>
      <td><?php echo "<b>", $member["name"], "</b><br/>", $member["role"]; ?></td>
      <td><br/><?php echo $member["donations"]; ?></td>
      <td><br/><?php echo $member["donationsReceived"]; ?></td>
      <td><?php echo $member["trophies"]; ?></td>
    </tr>
<?php
  }
?>
  </table>
</body>
</html>
