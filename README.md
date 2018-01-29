# How to run locally?
1. Eidting `MAILCHIMP_API_KEY` and `MAILCHIMP_API_BASE_URI` environment vars in `.env` file
2. Open `docker for mac`
3. Run `make start`
4. Run `docker ps` to get the container id, then use `docker exec -it [container_id] bash` to ssh into the container
5. Run commands (`src/Command/*`) to interact with Mailchimp
6. a sample command to create a list `php bin/console create:list --name=julian_test --company=julianli.co --address1=somewhere --city=melbourne --state=VIC --zip=3165 --country=Australia --permission_reminder="You signed up for updates on our website" --from_name=Julian --from_email=weiyi.li713@gmail.com --subject="Test Campaign" --language=English`
