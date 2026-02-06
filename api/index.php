<?php

// Ensure relative paths work correctly on Vercel
chdir(__DIR__ . '/..');

// Forward Vercel requests to the Laravel index.php
require __DIR__ . '/../public/index.php';
