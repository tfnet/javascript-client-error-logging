window.onerror = function(errorMessage, url, line) {
  var loggerUrl = "/jslogger/";
  var parameters = "?description=" + escape(errorMessage)
      + "&url=" + escape(url)
      + "&line=" + escape(line)
      + "&parent_url=" + escape(document.location.href)
      + "&user_agent=" + escape(navigator.userAgent);
 
  /** Send error to server */
  new Image().src = loggerUrl + parameters;
};