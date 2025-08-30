deploy:
	scp -r public/*.php jam@jamesg.blog:/var/www/rainfall.scot/public
	scp -r public/*.css jam@jamesg.blog:/var/www/rainfall.scot/public
	scp -r public/includes/* jam@jamesg.blog:/var/www/rainfall.scot/public/includes