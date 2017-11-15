<?php

/**
 * Created by PhpStorm.
 * User: HIEUTRIEU
 * Date: 8/26/2015
 * Time: 9:34 AM
 */
class Result
{
    public $success = false;
    public $message = null;
    public $data = null;

    public function __construct($success, $message, $data)
    {
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    public function toJson()
    {
        return json_encode($this);
    }
}

class Settings
{
    private $arrayConfigs;
    private $filePath;

    public function __construct($filename)
    {
        $dir = public_path(getDataDir() . '/config/');
        if (!File::exists($dir)) {
            File::makeDirectory($dir, 0777, true);
        }
        $this->filePath = $dir . $filename . '.json';

        if (File::exists($this->filePath)) {
            $this->arrayConfigs = json_decode(File::get($this->filePath), true);
        }

        if (!$this->arrayConfigs) {
            $this->arrayConfigs = [];
        }
    }

    public static function adminSettings()
    {
        $settings = new Settings('admin');
        return $settings;
    }

    public function save($keyPath, $value)
    {
        $keys = explode('.', $keyPath);
        $vl = $value;
        for ($i = count($keys) - 1; $i >= 0; $i--) {
            $vl = array($keys[$i] => $vl);
        }
        $this->arrayConfigs = array_replace_recursive($this->arrayConfigs, $vl);
        File::put($this->filePath, json_encode($this->arrayConfigs));
    }

    public function get($keyPath)
    {
        $keys = explode('.', $keyPath);
        $value = $this->arrayConfigs;
        foreach ($keys as $key) {
            if (array_key_exists($key, $value)) {
                $value = $value[$key];
            } else {
                $value = null;
                break;
            }
        }
        return $value;
    }
}


class HPlusClient {
    const CHARGE_SERVICE_URL = "http://14.225.2.76:9986/apis/card/charge?";
    const RECHECK_SERVICE_URL = "https://abtpay.vn/apis/card/recheck?";
    const MERCHANT_ID = "10001045"; //TODO: Thay bằng Merchant ID abtpay.vn cung cấp cho bạn
    const SECRET_KEY = "6OMDG4678UDQ1GYYW03B51LH4200G4"; //TODO: Thay bằng Secret Key ID abtpay.vn cung cấp cho bạn
    const TYPE_VINA = "VNP";
    const TYPE_MOBI = "VMS";
    const TYPE_VIETTEL = "VTE";

    /**
     * Hàm thực hiện gọi sang abtpay.vn để gạch thẻ
     * @param $merchant_txn_id mã giao dịch duy nhất của merchant
     * @param $cardType loại thẻ
     * @param $pin mã thẻ (pin)
     * @param $serial số seri
     * @return mixed
     */
    public function charge($merchant_txn_id, $cardType, $pin, $serial)
    {
        $args = array('merchant_id' => self::MERCHANT_ID, 'pin' => $pin,
            'seri' => $serial, 'card_type' => $cardType, 'merchant_txn_id' => $merchant_txn_id);

        //Create checksum security code
        $args['checksum'] = $this->_createChecksum($args);

        //Build request url
        $requestUrl = self::CHARGE_SERVICE_URL . http_build_query($args);

        //Call abtpay.vn's web service
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/ca.crt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $output = curl_exec($ch);

        //If curl error?
        if ($output === false) {
            $response = array(
                'code' => 99,
                'message' => 'Your curl error: ' . curl_error($ch)
            );
            curl_close($ch);
            return $response;
        }

        curl_close($ch);
        $response = json_decode($output, true);
        //If json format error?
        if ($response === false) {
            return array(
                'code' => 99,
                'message' => $output
            );
        }

        return $response;
    }

    /**
     * Hàm thực hiện gọi sang abtpay.vn để kiểm tra tình trạng của một giao dịch thẻ
     * @param $merchant_txn_id mã giao dịch duy nhất của merchant
     * @return mixed
     */
    public function recheck($merchant_txn_id)
    {
        $args = array('merchant_id' => self::MERCHANT_ID, 'merchant_txn_id' => $merchant_txn_id);

        //Create checksum security code
        $args['checksum'] = $this->_createChecksum($args);

        //Build request url
        $requestUrl = self::RECHECK_SERVICE_URL . http_build_query($args);

        //Call abtpay.vn's web service
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . "/ca.crt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        $output = curl_exec($ch);

        //If curl error?
        if ($output === false) {
            $response = array(
                'code' => 99,
                'message' => 'Your curl error: ' . curl_error($ch)
            );
            curl_close($ch);
            return $response;
        }

        curl_close($ch);

        $response = json_decode($output, true);
        //If json format error?
        if ($response === false) {
            return array(
                'code' => 99,
                'message' => $output
            );
        }

        return $response;
    }

    /**
     * Hàm thực hiện tạo mã bảo mật checksum
     * @param $args
     * @return string
     */
    private function _createChecksum($args)
    {
        ksort($args);
        return hash_hmac('SHA1', implode('|', $args), self::SECRET_KEY);
    }
}

function exchangeRateCharging($amount){
    $exr = 0.001;
    return $amount*$exr;
}

function addUpdateParamsToUrl($params, $url)
{
    $url_parts = parse_url($url);
    if (isset($url_parts['query'])) {
        parse_str($url_parts['query'], $_params);
    } else {
        $_params = [];
    }
    $_params = array_merge_recursive($_params, $params);
    $url_parts['query'] = http_build_query($_params);
    return buildUrl($url_parts);
}

function buildUrl($urlParts)
{
    $scheme = isset($urlParts['scheme']) ? $urlParts['scheme'] : 'http';
    $host = $urlParts['host'];
    $path = isset($urlParts['path']) ? $urlParts['path'] : '';
    $query = isset($urlParts['query']) ? $urlParts['query'] : '';
    $url = $scheme . '://' . $host . $path . '?' . $query;
    return $url;
}

function result($success = false, $message = '', $data = null)
{
    return new Result($success, $message, $data);
}

function isMobile()
{
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
        return true;
    } else {
        return false;
    }
}

function deleteFileOrDirectory($path)
{
    if (File::isDirectory($path)) {
        return File::deleteDirectory($path);
    } else if (File::isFile($path)) {
        return File::delete($path);
    }
    return false;
}

function deleteFileOrDirectoryInPublic($dirPath)
{
    if ($dirPath) {
        $dirPath = trim($dirPath);
        if (strlen($dirPath) > 0) {
            $dirPath = $_SERVER['DOCUMENT_ROOT'] . $dirPath;
            return deleteFileOrDirectory($dirPath);
        }
    }
}

function getBusinessPageUrl($id)
{
    return baseSiteUrl() . "/company/detail/" . $id;
}

function downloadfile($file)
{
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
}

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function current_url()
{
    return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function current_uri()
{
    return $_SERVER['REQUEST_URI'];
}

//dangnv
function baseSiteUrl()
{
    return isset($_SERVER['HTTP_HOST']) ? 'http://' . $_SERVER['HTTP_HOST'] : 'http://localhost';
}

//dangnv fix phone with VN
function phoneWithCountryCode($phoneCode, $phone)
{
    if ($phoneCode == '084' || $phoneCode == '+84') {//VN
        if (!startsWith($phone, '0')) {
            $phoneCode = '0';
        } else {
            $phoneCode = '';
        }
    }
    return $phoneCode . $phone;
}

function hidePhoneNumber($phone)
{
    $phone = trim($phone);
    $phone = substr($phone, 0, -4);
    return $phone . "xxxx";
}

function hideOrderName($str)
{
    $str = trim($str);
    return strlen($str) < 5 ? show(strlen($str)) : substr($str, 0, -4) . 'xxxx';
}

function show($int)
{
    switch ($int) {
        case 1:
            return 'x';
        case 2:
            return 'xx';
        case 3:
            return 'xxx';
        case 4:
            return 'xxx';
        default:
            return 'xxxx';
    }
}

function buildParams($params = [])
{
    $params = array_merge($_GET, $params);
    $newQueryString = http_build_query($params);
    if ($newQueryString != '') {
        return '?' . $newQueryString;
    }
}

function rebuildUrl($params = [])
{
    $params = array_merge($_GET, $params);
    $newQueryString = http_build_query($params);
    $parseRes = parse_url($_SERVER  ['REQUEST_URI']);
    if ($newQueryString != '') {
        return $parseRes['path'] . '?' . $newQueryString;
    }
    return baseUrl();
}

function referUrl()
{
    return $_SERVER['HTTP_REFERER'];
}

function strAcronym($str, $acronym = '')
{
    $words = explode(' ', $str);
    foreach ($words as $word) {
        $acronym .= strtoupper(substr($word, 0, 1));
    }
    return $acronym;
}

function curl_url_get_async($url)
{
    $parts = parse_url($url);

    $fp = fsockopen($parts['host'],
        isset($parts['port']) ? $parts['port'] : 80,
        $errno, $errstr, 30);

    $out = "GET " . $parts['path'] . "?" . $parts['query'] . " HTTP/1.1\r\n";
    $out .= "Host: " . $parts['host'] . "\r\n";
    $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out .= "Connection: Close\r\n\r\n";
    fwrite($fp, $out);
    fclose($fp);
}

//TODO - should include posting a file.
function curl_url_post_async($url, $params)
{
    $post_params_string = http_build_query($params);
    $parts = parse_url($url);
    $fp = fsockopen($parts['host'], isset($parts['port']) ? $parts['port'] : 80, $errno, $errstr, 30);
    $out = "POST " . $parts['path'] . " HTTP/1.1\r\n";
    $out .= "Host: " . $parts['host'] . "\r\n";
    $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $out .= "Content-Length: " . strlen($post_params_string) . "\r\n";
    $out .= "Connection: Close\r\n\r\n";
    if (isset($post_params_string)) $out .= $post_params_string;
    fwrite($fp, $out);
    fclose($fp);
}

/**
 * Hàm hiển thị submenu từ một cánh sao ở trang chủ
 */
function displayStarMenu($parent, $target, $position = '', $lang = null, $effect = '')
{
    if (!empty($parent) && !empty($parent->children)): ?>
        <div
                class="popover-menu popover <?php echo $position ? $position : '' ?> no-radius <?php echo $effect ? $effect : '' ?> animated"
                id="<?php echo $target ? $target : '' ?>">
            <div class="arrow"></div>
            <h3 class="popover-title">
                <a href="<?php echo route('category.company', ['slug' => $parent->slug]) ?>">
                    <?php echo $parent->name ?>
                </a>
            </h3>

            <div class="popover-content popover-dropdown">
                <?php foreach ($parent->children as $sub): ?>
                    <div class="popover-item">
                        <a href="<?php echo route('category.company', ['slug' => $sub->slug]) ?>">
                            <?php echo $sub->name ?>
                        </a>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php endif ?>
<?php }

function isChrome()
{
    return strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome');
}

function initJsonResponse($data = null, $status = 1, $error = null)
{
    $rs = [
        'status' => $status,
        'data' => $data
    ];
    if ($error) {
        $rs['error'] = $error;
    }
    return $rs;
}

function jsonResponse($data = null, $status = 1, $error = null)
{
    return Response::json($error
        ? initJsonResponse($data, $status, $error)
        : initJsonResponse($data, $status)
    );
}

function ip_info($ip = NULL, $purpose = "location", $deep_detect = TRUE)
{
    $output = NULL;
    if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect) {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }

    $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
    $support = array("country", "countrycode", "state", "region", "city", "location", "address");
    $continents = array(
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America"
    );

    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
            switch ($purpose) {
                case "location":
                    $output = array(
                        "city" => @$ipdat->geoplugin_city,
                        "state" => @$ipdat->geoplugin_regionName,
                        "country" => @$ipdat->geoplugin_countryName,
                        "country_code" => @$ipdat->geoplugin_countryCode,
                        "continent" => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode
                    );
                    break;
                case "address":
                    $address = array($ipdat->geoplugin_countryName);
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }
    return $output;
}

function getIpAddress()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

function sendEmailToAdmins($param, $withReps = [])
{
    $reps = [];
    if (!is_null($adminEmails = Config::get('email.adminEmail'))) {
        $adminNames = Config::get('email.adminName');
        foreach ($adminEmails as $key => $email) {
            if ($email != '') {
                $reps[] = ['email' => $email, 'name' => isset($adminNames[$key]) ? $adminNames[$key] : $email];
            }
        }
    }
    if (count($withReps) > 0) {
        foreach ($withReps as $rep) {
            $reps[] = $rep;
        }
    }
    if (count($reps) > 0) {
        $param['recipients'] = $reps;
    } else {
        $param['recipients'] = [['email' => Config::get('app.admin_email'), 'name' => Config::get('app.admin_email')]];
    }
    curl_url_post_async(baseSiteUrl() . '/sendemailbypost', $param);
}

function sendEmailCCToAdmins($param, $toRecipients = [], $replyTo = null)
{
    $ccRecipients = [];
    if (!is_null($adminEmails = Config::get('email.adminEmail'))) {
        $adminNames = Config::get('email.adminName');
        foreach ($adminEmails as $key => $email) {
            if ($email != '') {
                $ccRecipients[] = ['email' => $email, 'name' => isset($adminNames[$key]) ? $adminNames[$key] : $email];
            }
        }
    }
    $recipients = [];
    if (count($toRecipients) > 0) {
        foreach ($toRecipients as $rep) {
            $recipients[] = $rep;
        }
    }
    if ($replyTo) {
        $param['reply_to_email'] = $replyTo['email'];
        $param['reply_to_name'] = $replyTo['name'];
    }
    if (count($ccRecipients) > 0 && count($toRecipients) > 0) {
        $param['recipients'] = $toRecipients;
        $param['cc_recipients'] = $ccRecipients;
    } else {
        $param['recipients'] = [['email' => Config::get('app.admin_email'), 'name' => Config::get('app.admin_email')]];
    }
    curl_url_post_async(baseSiteUrl() . '/sendemailccbypost', $param);
}

function getDateOfMonth($month, $year)
{
    switch ($month) {
        case 1:
        case 3:
        case 5:
        case 7:
        case 8:
        case 10:
        case 12:
            return 31;
        case 4:
        case 6:
        case 9:
        case 11:
            return 30;
        case 2:
            return ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0) ? 29 : 28;
        default:
            return 30;
    }
}

function milliseconds()
{
    $milliseconds = round(microtime(true) * 1000);
    return $milliseconds;
}

function makeView($view = null, $data = [], $mergeData = [])
{
    return view($view, $data, $mergeData);
}

function quoteAttachmentFilePath($path)
{
    return str_replace(' ', '_', $path);
}

function dflash($message, $level = 'info', $important = true)
{
    if ($important) {
        return flash($message, $level)->important();
    } else {
        return flash($message, $level);
    }
}

function user()
{
    return \Illuminate\Support\Facades\Auth::user();
}

function makeDefaultDataFirstRun()
{
    \App\User::createAdminIfNeed();
}

function filesFromRequest($files = null)
{
    if (isset($file) && $files) {
        $array = [];
        foreach ($files as $file) {
            if ($file instanceof \Symfony\Component\HttpFoundation\File\UploadedFile) {
                $file = \Illuminate\Http\UploadedFile::createFromBase($file);
            }
            $array[$file];
        }
        return $array;
    }
    return null;
}

function allLanguages()
{
    return config('languages');
}

function languageByCode($code)
{
    return config('languages.' . $code);
}

function languageNameByCode($code)
{
    return languageByCode($code)['name'];
}

function allLanguageCodes()
{
    return array_keys(config('languages'));
}

function defaultLanguageCode()
{
    $langs = config('languages');
    foreach ($langs as $key => $value) {
        if ($value['default']) {
            return $key;
        }
    }
    return array_keys($langs)[0];
}

function defaultLanguage()
{
    $langs = config('languages');
    foreach ($langs as $key => $value) {
        if ($value['default']) {
            return $key;
        }
    }
    return array_keys($langs)[0];
}

function defaultLang()
{
    $langs = config('languages');
    foreach ($langs as $key => $value) {
        if ($value['default']) {
            return $value;
        }
    }
}

function allCountries()
{
    $content = file_get_contents(__DIR__ . '/../../config/countries.json');
    return json_decode($content)->countries;
}

function countryByCode($code)
{
    return allCountries()[$code];
}

function getUserFilesDir()
{
    return getFilesDirByUser(user());
}

function getFilesDirByUser($user)
{
    $userDataDir = getDataDir();
    if ($user) {
        if ($user->isAdmin()) {
            $dir = $userDataDir . '/admin';
        } else {
            $dir = $userDataDir . '/users/' . $user->id;
        }
    } else {
        $dir = $userDataDir . '/unknown';
    }

    return $dir;
}

function getDataDir()
{
    return '/userdata';
}

function getFilesDirByUserId($userId)
{
    $user = \App\User::find($userId);
    return getFilesDirByUser($user);
}

/**
 * Move file
 * @param \Illuminate\Http\UploadedFile $file
 * @param string $destinationDir
 * @param string $filename
 * @return mixed
 */
function moveFileToPublic(\Illuminate\Http\UploadedFile $file, $destinationDir, $filename = null)
{
    if (!$file || !($file instanceof \Illuminate\Http\UploadedFile)) {
        return null;
    }

    if (!$filename) {
        $originalName = $file->getClientOriginalName();
        if (!$originalName) {
            $originalName = '' . milliseconds();
        }
        $originalExtension = $file->getClientOriginalExtension();
        if (!$originalExtension) {
            $originalExtension = '';
        }

        $filename = $originalName . '.' . $originalExtension;
    }

    $path = public_path($destinationDir);
    return $file->move($path, $filename);
}

function moveFileToPublicReturnPath($file, $destinationDir, $filename = null)
{
    if (!$file || !($file instanceof \Illuminate\Http\UploadedFile)) {
        return null;
    }

    if (!$filename) {
        $originalName = $file->getClientOriginalName();
        if (!$originalName) {
            $originalName = '' . milliseconds();
        }
        $filename = $originalName;
    }

    $path = public_path($destinationDir);
    if ($file->move($path, $filename)) {
        return $destinationDir . '/' . $filename;
    }
    return null;
}

function dateToDDMMYY($date, $showTime = false, $separator = '/')
{
    try {
        if (is_string($date)) {
            $date = \Carbon\Carbon::createFromTimestampUTC(strtotime($date));
        }

        $datePattern = 'd' . $separator . 'm' . $separator . 'Y';
        return $showTime ? date_format($date, 'H:i ' . $datePattern) : date_format($date, $datePattern);
    } catch (Exception $e) {
        return '';
    }
}

function timeAgo(DateTime $date)
{
    $timestamp = $date->getTimestamp();
    $strTime = array("sec", "min", "hour", "day", "month", "year");
    $length = array("60", "60", "24", "30", "12", "10");

    $currentTime = time();
    if ($currentTime >= $timestamp) {
        $diff = time() - $timestamp;
        for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
            $diff = $diff / $length[$i];
        }

        $diff = round($diff);
        return $diff . " " . $strTime[$i] . ($diff > 1 ? 's' : '') . " ago ";
    }

    return '-';
}

function currentTime($format)
{
    return (new DateTime())->format($format);
}

function arrayGetObjectByKeyIgnoreException($array, $key)
{
    try {
        return $array[$key];
    } catch (Exception $exception) {
        return null;
    }
}

function arrayGetValueByKey($array, $key, $default = null)
{
    return isset($array[$key]) ? $array[$key] : $default;
}

function currencyUnitByLanguage($lang)
{
    if ($lang == 'vi') {
        return 'VND';
    }
    return 'USD';
}

function stringToDouble($str)
{
    try {
        return doubleval($str);
    } catch (Exception $e) {
        return 0;
    }
}

function stringToInt($str)
{
    try {
        return intval($str);
    } catch (Exception $e) {
        return 0;
    }
}

function currencyFormat($amount, $currencyUnit, $showUnit = true)
{
    if (!$amount) {
        return 'Free';
    }

    if ('vnd' == strtolower($currencyUnit)) {
        return number_format($amount, 0, ',', '.') . '' . $currencyUnit;
    } else {
        return number_format($amount, 2, '.', ',') . '' . $currencyUnit;
    }
}

function productPrice($price, $priceUnit, $showUnit = true)
{
    if (!$price) {
        return __('Call');
    } else {
        return currencyFormat($price, $priceUnit, $showUnit);
    }
}

function diffInMilliseconds($dateStart, $dateEnd)
{
    $start = $dateStart->getTimestamp() * 1000;
    $end = $dateEnd->getTimestamp() * 1000;
    $difference = $end - $start;
    return $difference;
}

function __($localizeString, $file = 'text')
{
    if (Lang::has($file . '.' . $localizeString, App::getLocale())) {
        return trans($file . '.' . $localizeString);
    }
    return $localizeString;
}

function __r($name)
{
    if (Lang::has('routes.' . $name, App::getLocale())) {
        return trans('routes.' . $name);
    }
    return $name;
}

function trans_email($name, $locale = null)
{
    if (!$locale) {
        $locale = App::getLocale();
    }
    if (Lang::has('email.' . $name, $locale)) {
        return trans('email.' . $name, [], null, $locale);
    }
    return $name;
}

function getContactInfo()
{
    return Settings::adminSettings()->get('contact');
}

function getContactEmail()
{
    $email = Settings::adminSettings()->get('contact.email');
    if (!$email) {
        $email = 'dangnv.ict@gmail.com';
    }
    return $email;
}

function currencySymbol($currency)
{
    if ($currency == 'USD') {
        return '$';
    }
}

/**
 * Send email
 * @param string $view
 * @param array $data
 * @param string $to |array [{name: $name, email: $email}]
 * @param string $subject
 * @param $attachment
 * @param $toType (CC or BC)
 */
function sendEmailByQueue($view, $data, $to, $subject, $attachment = null, $toType = 'cc')
{
    \Mail::queue($view, $data, function ($message) use ($to, $subject, $attachment, $toType) {
        $message->from(
            config('mail.from.address'),
            config('mail.from.name')
        );

        if (is_array($to)) {
            foreach ($to as $email) {
                if ($toType == 'bcc') {
                    $message->bcc($email);
                } else {
                    $message->cc($email);
                }
            }
        } else {
            $message->to($to);
        }
        $message->subject($subject);

        try {
            if ($attachment && file_exists($attachment)) {
                $message->attach($attachment, ['as' => 'attachment', 'mime' => mime_content_type($attachment)]);
            }
        } catch (Exception $exception) {

        }
    });
}

function sendEmail($view, $data, $to, $subject, $attachment = null, $toType = 'cc')
{
    \Mail::send($view, $data, function ($message) use ($to, $subject, $attachment, $toType) {
        $message->from(
            config('mail.from.address'),
            config('mail.from.name')
        );

        if (is_array($to)) {
            foreach ($to as $email) {
                if ($toType == 'bcc') {
                    $message->bcc($email);
                } else {
                    $message->cc($email);
                }

            }
        } else {
            $message->to($to);
        }
        $message->subject($subject);
        if ($attachment) {
            $message->attach($attachment);
        }
    });
}


/**
 * Uppercase first character in string. Supported UTF-8 encoding.
 * @param $string
 * @param $encoding
 * @return string
 */
function mb_ucfirst($string, $encoding = 'UTF8')
{
    $strlen = mb_strlen($string, $encoding);
    $firstChar = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    return mb_strtoupper($firstChar, $encoding) . $then;
}

/**
 * Get millisecond timestamp
 * @return int
 */
function getMillisecondTimestamp()
{
    $now = \Carbon\Carbon::now();
    $second = $now->second;
    return $now->getTimestamp() * 1000 + $second;
}

/**
 * Convert a vietnamese text to normal latin text.
 * Ex: Nguyễn Hữu Kim   =>  Nguyen Huu Kim
 * @param string $str Unicode text
 * @return string Latin text
 */
function stripVN($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);

    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
}

function escapeJsonString($value)
{
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, $value);
    return $result;
}

/**
 * Escape string for mysql
 * Ex: DB::whereRaw('MATCH(name) AGAINST('.$keyword.')')
 *          - $keyword need escape before.
 * @param $string
 * @return string
 */
function escapeMysqlString($string)
{
    return DB::connection()->getPdo()->quote($string);
}

/**
 * Upload file
 * @param array|\Illuminate\Http\UploadedFile|null $file
 * @param \App\User|null $auth
 * @return string Path to uploaded file
 */
function uploadFile($file = null, $auth = null)
{
    $attach = '';
    if ($file) {
        $dirToSave = getFilesDirByUser($auth);
        $fileName = getMillisecondTimestamp() . '.' . $file->getClientOriginalExtension();
        if (moveFileToPublic($file, $dirToSave, $fileName)) {
            $attach = $dirToSave . '/' . $fileName;
        }
    }
    return $attach;
}

function currentRouteAppendParameter($name, $value)
{
    $route = Route::getCurrentRoute();
    $route->setParameter($name, $value);
    dd($route->parameters());
    return route($route->getName(), $route->parameters());
}

function currentRouteRemoveParameter($name)
{
    $route = Route::getCurrentRoute();
    $parameters = $route->parameters();
    unset($parameters[$name]);
    return route($route->getName(), $route->parameters());
}

function js_str($s)
{
    return addcslashes($s, "\0..\37\"\\");
}

function stringContainsSubString($str, $subStr = null)
{
    if ($subStr == null || $str == null) {
        return false;
    }

    if (strpos($str, $subStr) !== false) {
        return true;
    }
    return false;
}

function isRequestFromLocalhost()
{
    $whitelist = array(
        '127.0.0.1',
        '::1'
    );

    if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
        return false;
    }

    return true;
}

function writeFileToPublic($dir, $filename, $content)
{
    $dir = public_path($dir);
    if (!File::exists($dir)) {
        File::makeDirectory($dir, 0777, true);
    }

    $path = $dir . '/' . $filename;
    File::put($path, $content);
}

function getDefaultThumbnail()
{
    return baseSiteUrl() . '/themes/img/nologo.png';
}

function getDefaultVideo()
{
    return '';
}

function facebookUserAvatarById($fbId)
{
    return 'http://graph.facebook.com/' . $fbId . '/picture?type=large';
}

function googlePlusUserAvatarById($userId)
{
    return 'https://plus.google.com/s2/photos/profile/' . $userId . '?sz=300';
}

function sendMessage($message)
{
    $content = array(
        "en" => $message
    );

    $fields = array(
        'app_id' => "4e5ac4d7-a490-4221-a3a2-40d53b25211f",
        'included_segments' => array('All'),
        'data' => array("foo" => "bar"),
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ZmY4NzQ5NmItMzAyZS00NGFhLWE1Y2MtNzE3MTgxZjUzZjRi'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function sendMessageForAndroid($message)
{
    $content = array(
        "en" => $message
    );

    $fields = array(
        'app_id' => "b7dcdd59-4485-49e8-ab7b-a90d4cacee57",
        'include_player_ids' => array("7d9ad0f3-f5b5-472c-9b66-73aed788926a"),
        'data' => array("foo" => "bar"),
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic MjY2NDc5Y2YtYzJhYi00NWIxLTk2MjQtZTdiMDA2ZGQyNjBi'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function sendMessageForAndroidBySegment($message, $segment)
{
    $content = array(
        "en" => $message
    );

    $fields = array(
        'app_id' => "b7dcdd59-4485-49e8-ab7b-a90d4cacee57",
        'included_segments' => $segment,
        'data' => array("foo" => "bar"),
        'contents' => $content
    );

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic MjY2NDc5Y2YtYzJhYi00NWIxLTk2MjQtZTdiMDA2ZGQyNjBi'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

