<?php

Event::listen('*', function () {
	Clockwork::info(Event::firing()); // uses clockwork - https://github.com/itsgoingd/clockwork
	Log::info(Event::firing()); // saves to your log file
});
