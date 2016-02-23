Instrucciones para actualizar ETL

sudo ansible-galaxy install -r requirements.yml
ansible-playbook site.yml --ask-sudo-pass -s -u drevelo -i allservers.yml -l production

