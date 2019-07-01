# hh_simple_downloadcounter
hh_simple_downloadcounter is a TYPO3 extension.
This Extension provides a eID Script to safe and update clicks on file-links (counts) and it provides a backend module which shows all files and there click-count.

### Installation
... like any other TYPO3 extension for example: [extensions.typo3.org](https://extensions.typo3.org/extension/hh_video/ "TYPO3 Extension Repository")

### Usage
Send an POST ajax-call to "?eID=count_downloads&file=PATH_TO_YOUR_FILE"
Example:
```javascript
io.elementsEach(".count-downloads li a", function(el) {
    // el.setAttribute("download", "");
    el.addEventListener("click", function(e) {
        // e.preventDefault();
        var url = el.getAttribute("href");
        $.post("http://"+window.location.hostname+"?eID=count_downloads&file="+url, function(data) {
        });
    })
});
```

### Features

### Todos

### Deprecated

### IMPORTENT NOTICE

#### Module View

##### Copyright notice

This repository is part of the TYPO3 project. The TYPO3 project is
free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

The GNU General Public License can be found at
http://www.gnu.org/copyleft/gpl.html.

This repository is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

This copyright notice MUST APPEAR in all copies of the repository!

##### License
----
GNU GENERAL PUBLIC LICENSE Version 3
