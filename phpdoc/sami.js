
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:WebFilesystem" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="WebFilesystem.html">WebFilesystem</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:WebFilesystem_FileType" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="WebFilesystem/FileType.html">FileType</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:WebFilesystem_FileType_WebImage" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebFilesystem/FileType/WebImage.html">WebImage</a>                    </div>                </li>                            <li data-name="class:WebFilesystem_FileType_WebVideo" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="WebFilesystem/FileType/WebVideo.html">WebVideo</a>                    </div>                </li>                </ul></div>                </li>                            <li data-name="class:WebFilesystem_Finder" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebFilesystem/Finder.html">Finder</a>                    </div>                </li>                            <li data-name="class:WebFilesystem_WebFileInfo" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebFilesystem/WebFileInfo.html">WebFileInfo</a>                    </div>                </li>                            <li data-name="class:WebFilesystem_WebFilesystem" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebFilesystem/WebFilesystem.html">WebFilesystem</a>                    </div>                </li>                            <li data-name="class:WebFilesystem_WebFilesystemIterator" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebFilesystem/WebFilesystemIterator.html">WebFilesystemIterator</a>                    </div>                </li>                            <li data-name="class:WebFilesystem_WebRecursiveDirectoryIterator" class="opened">                    <div style="padding-left:26px" class="hd leaf">                        <a href="WebFilesystem/WebRecursiveDirectoryIterator.html">WebRecursiveDirectoryIterator</a>                    </div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "WebFilesystem.html", "name": "WebFilesystem", "doc": "Namespace WebFilesystem"},{"type": "Namespace", "link": "WebFilesystem/FileType.html", "name": "WebFilesystem\\FileType", "doc": "Namespace WebFilesystem\\FileType"},
            
            {"type": "Class", "fromName": "WebFilesystem\\FileType", "fromLink": "WebFilesystem/FileType.html", "link": "WebFilesystem/FileType/WebImage.html", "name": "WebFilesystem\\FileType\\WebImage", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method___construct", "name": "WebFilesystem\\FileType\\WebImage::__construct", "doc": "&quot;Construct a new myDirectory object&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_setThumbFilename", "name": "WebFilesystem\\FileType\\WebImage::setThumbFilename", "doc": "&quot;Sets the object thumb file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getThumbFilename", "name": "WebFilesystem\\FileType\\WebImage::getThumbFilename", "doc": "&quot;Get the object&#039;s thumb file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getThumbBasename", "name": "WebFilesystem\\FileType\\WebImage::getThumbBasename", "doc": "&quot;Get the object&#039;s thumb file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_setThumbRootDir", "name": "WebFilesystem\\FileType\\WebImage::setThumbRootDir", "doc": "&quot;Sets the object thumb root directory&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getThumbRootDir", "name": "WebFilesystem\\FileType\\WebImage::getThumbRootDir", "doc": "&quot;Get the object&#039;s thumb root directory&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_setThumbPath", "name": "WebFilesystem\\FileType\\WebImage::setThumbPath", "doc": "&quot;Sets the object thumb web path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getThumbPath", "name": "WebFilesystem\\FileType\\WebImage::getThumbPath", "doc": "&quot;Get the object&#039;s thumb web path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getThumbPathname", "name": "WebFilesystem\\FileType\\WebImage::getThumbPathname", "doc": "&quot;Get the object&#039;s thumb web path with file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getThumbRealPath", "name": "WebFilesystem\\FileType\\WebImage::getThumbRealPath", "doc": "&quot;Get the object&#039;s web real path (with the file_name)\nThis returns a directly HTML writable directory or file path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getThumbWebPath", "name": "WebFilesystem\\FileType\\WebImage::getThumbWebPath", "doc": "&quot;Get the object&#039;s thumb web path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getThumbRealWebPath", "name": "WebFilesystem\\FileType\\WebImage::getThumbRealWebPath", "doc": "&quot;Get the object&#039;s web real path (with the file_name)\nThis returns a directly HTML writable directory or file path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getInfos", "name": "WebFilesystem\\FileType\\WebImage::getInfos", "doc": "&quot;Scan all image infos&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getImageInfos", "name": "WebFilesystem\\FileType\\WebImage::getImageInfos", "doc": "&quot;Scan image standrad infos&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getIptcInfos", "name": "WebFilesystem\\FileType\\WebImage::getIptcInfos", "doc": "&quot;Scan image IPTC infos&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getExifInfos", "name": "WebFilesystem\\FileType\\WebImage::getExifInfos", "doc": "&quot;Scan image EXIF infos&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_exists", "name": "WebFilesystem\\FileType\\WebImage::exists", "doc": "&quot;Check if the object exists&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_thumbExists", "name": "WebFilesystem\\FileType\\WebImage::thumbExists", "doc": "&quot;Check if the thumb exists&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_isImage", "name": "WebFilesystem\\FileType\\WebImage::isImage", "doc": "&quot;Returns TRUE if the object is an image&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getGps", "name": "WebFilesystem\\FileType\\WebImage::getGps", "doc": "&quot;Returns the transformed value of an EXIF GPS field to a standard GPS floated coordinate&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_gps2Num", "name": "WebFilesystem\\FileType\\WebImage::gps2Num", "doc": "&quot;Returns a transformed GPS coordinate in a numeric floated value&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getDateFromExif", "name": "WebFilesystem\\FileType\\WebImage::getDateFromExif", "doc": "&quot;Returns the transformed date field form EXIF info to SQL DateTime format &lt;code&gt;AAAA-MM-DD HH:ii:ss&lt;\/code&gt;&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getBase64Content", "name": "WebFilesystem\\FileType\\WebImage::getBase64Content", "doc": "&quot;Get the &lt;code&gt;base64&lt;\/code&gt; encoded image content&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getHeight", "name": "WebFilesystem\\FileType\\WebImage::getHeight", "doc": "&quot;Get the image&#039;s height in pixels&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebImage", "fromLink": "WebFilesystem/FileType/WebImage.html", "link": "WebFilesystem/FileType/WebImage.html#method_getWidth", "name": "WebFilesystem\\FileType\\WebImage::getWidth", "doc": "&quot;Get the image&#039;s width in pixels&quot;"},
            
            {"type": "Class", "fromName": "WebFilesystem\\FileType", "fromLink": "WebFilesystem/FileType.html", "link": "WebFilesystem/FileType/WebVideo.html", "name": "WebFilesystem\\FileType\\WebVideo", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method___construct", "name": "WebFilesystem\\FileType\\WebVideo::__construct", "doc": "&quot;Construct a new myDirectory object&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_setThumbFilename", "name": "WebFilesystem\\FileType\\WebVideo::setThumbFilename", "doc": "&quot;Sets the object thumb file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getThumbFilename", "name": "WebFilesystem\\FileType\\WebVideo::getThumbFilename", "doc": "&quot;Get the object&#039;s thumb file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getThumbBasename", "name": "WebFilesystem\\FileType\\WebVideo::getThumbBasename", "doc": "&quot;Get the object&#039;s thumb file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_setThumbRootDir", "name": "WebFilesystem\\FileType\\WebVideo::setThumbRootDir", "doc": "&quot;Sets the object thumb root directory&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getThumbRootDir", "name": "WebFilesystem\\FileType\\WebVideo::getThumbRootDir", "doc": "&quot;Get the object&#039;s thumb root directory&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_setThumbPath", "name": "WebFilesystem\\FileType\\WebVideo::setThumbPath", "doc": "&quot;Sets the object thumb web path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getThumbPath", "name": "WebFilesystem\\FileType\\WebVideo::getThumbPath", "doc": "&quot;Get the object&#039;s thumb web path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getThumbPathname", "name": "WebFilesystem\\FileType\\WebVideo::getThumbPathname", "doc": "&quot;Get the object&#039;s thumb web path with file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getThumbRealPath", "name": "WebFilesystem\\FileType\\WebVideo::getThumbRealPath", "doc": "&quot;Get the object&#039;s web real path (with the file_name)\nThis returns a directly HTML writable directory or file path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getThumbWebPath", "name": "WebFilesystem\\FileType\\WebVideo::getThumbWebPath", "doc": "&quot;Get the object&#039;s thumb web path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getThumbRealWebPath", "name": "WebFilesystem\\FileType\\WebVideo::getThumbRealWebPath", "doc": "&quot;Get the object&#039;s web real path (with the file_name)\nThis returns a directly HTML writable directory or file path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getInfos", "name": "WebFilesystem\\FileType\\WebVideo::getInfos", "doc": "&quot;Scan all image infos&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getVideoInfos", "name": "WebFilesystem\\FileType\\WebVideo::getVideoInfos", "doc": "&quot;Scan video standrad infos&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_exists", "name": "WebFilesystem\\FileType\\WebVideo::exists", "doc": "&quot;Check if the object exists&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_thumbExists", "name": "WebFilesystem\\FileType\\WebVideo::thumbExists", "doc": "&quot;Check if the thumb exists&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_isVideo", "name": "WebFilesystem\\FileType\\WebVideo::isVideo", "doc": "&quot;Returns TRUE if the object is a video file&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\FileType\\WebVideo", "fromLink": "WebFilesystem/FileType/WebVideo.html", "link": "WebFilesystem/FileType/WebVideo.html#method_getDateFromExif", "name": "WebFilesystem\\FileType\\WebVideo::getDateFromExif", "doc": "&quot;Returns the transformed date field form EXIF info to SQL DateTime format &lt;code&gt;AAAA-MM-DD HH:ii:ss&lt;\/code&gt;&quot;"},
            
            {"type": "Class", "fromName": "WebFilesystem", "fromLink": "WebFilesystem.html", "link": "WebFilesystem/Finder.html", "name": "WebFilesystem\\Finder", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_init", "name": "WebFilesystem\\Finder::init", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_reset", "name": "WebFilesystem\\Finder::reset", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setInited", "name": "WebFilesystem\\Finder::setInited", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_isInited", "name": "WebFilesystem\\Finder::isInited", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setRootDir", "name": "WebFilesystem\\Finder::setRootDir", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getRootDir", "name": "WebFilesystem\\Finder::getRootDir", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_addDirectory", "name": "WebFilesystem\\Finder::addDirectory", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setDirectories", "name": "WebFilesystem\\Finder::setDirectories", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getDirectories", "name": "WebFilesystem\\Finder::getDirectories", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_addExcludedDirectory", "name": "WebFilesystem\\Finder::addExcludedDirectory", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setExcludedDirectories", "name": "WebFilesystem\\Finder::setExcludedDirectories", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getExcludedDirectories", "name": "WebFilesystem\\Finder::getExcludedDirectories", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_addNameMask", "name": "WebFilesystem\\Finder::addNameMask", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setNameMasks", "name": "WebFilesystem\\Finder::setNameMasks", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getNameMasks", "name": "WebFilesystem\\Finder::getNameMasks", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_addExcludedNameMask", "name": "WebFilesystem\\Finder::addExcludedNameMask", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setExcludedNameMasks", "name": "WebFilesystem\\Finder::setExcludedNameMasks", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getExcludedNameMasks", "name": "WebFilesystem\\Finder::getExcludedNameMasks", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_addExtensionMask", "name": "WebFilesystem\\Finder::addExtensionMask", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setExtensionMasks", "name": "WebFilesystem\\Finder::setExtensionMasks", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getExtensionMasks", "name": "WebFilesystem\\Finder::getExtensionMasks", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_addExcludedExtensionMask", "name": "WebFilesystem\\Finder::addExcludedExtensionMask", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setExcludedExtensionMasks", "name": "WebFilesystem\\Finder::setExcludedExtensionMasks", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getExcludedExtensionMasks", "name": "WebFilesystem\\Finder::getExcludedExtensionMasks", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setDepth", "name": "WebFilesystem\\Finder::setDepth", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getDepth", "name": "WebFilesystem\\Finder::getDepth", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setIteratorFlags", "name": "WebFilesystem\\Finder::setIteratorFlags", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getIteratorFlags", "name": "WebFilesystem\\Finder::getIteratorFlags", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_setFlag", "name": "WebFilesystem\\Finder::setFlag", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getFlag", "name": "WebFilesystem\\Finder::getFlag", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_files", "name": "WebFilesystem\\Finder::files", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_dirs", "name": "WebFilesystem\\Finder::dirs", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_links", "name": "WebFilesystem\\Finder::links", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_dots", "name": "WebFilesystem\\Finder::dots", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_depth", "name": "WebFilesystem\\Finder::depth", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_name", "name": "WebFilesystem\\Finder::name", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_notName", "name": "WebFilesystem\\Finder::notName", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_extension", "name": "WebFilesystem\\Finder::extension", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_notExtension", "name": "WebFilesystem\\Finder::notExtension", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_in", "name": "WebFilesystem\\Finder::in", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_notIn", "name": "WebFilesystem\\Finder::notIn", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_root", "name": "WebFilesystem\\Finder::root", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_images", "name": "WebFilesystem\\Finder::images", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_videos", "name": "WebFilesystem\\Finder::videos", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_is", "name": "WebFilesystem\\Finder::is", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_isFile", "name": "WebFilesystem\\Finder::isFile", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_isDir", "name": "WebFilesystem\\Finder::isDir", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_isLink", "name": "WebFilesystem\\Finder::isLink", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_isImage", "name": "WebFilesystem\\Finder::isImage", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_isVideo", "name": "WebFilesystem\\Finder::isVideo", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_isDotFile", "name": "WebFilesystem\\Finder::isDotFile", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_getIterator", "name": "WebFilesystem\\Finder::getIterator", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_current", "name": "WebFilesystem\\Finder::current", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_key", "name": "WebFilesystem\\Finder::key", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_next", "name": "WebFilesystem\\Finder::next", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_rewind", "name": "WebFilesystem\\Finder::rewind", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\Finder", "fromLink": "WebFilesystem/Finder.html", "link": "WebFilesystem/Finder.html#method_valid", "name": "WebFilesystem\\Finder::valid", "doc": "&quot;\n&quot;"},
            
            {"type": "Class", "fromName": "WebFilesystem", "fromLink": "WebFilesystem.html", "link": "WebFilesystem/WebFileInfo.html", "name": "WebFilesystem\\WebFileInfo", "doc": "&quot;Special web&#039;s version of the PHP &gt;=5.1.2 standard class &lt;code&gt;SplFileInfo&lt;\/code&gt; &lt;a href=\&quot;http:\/\/www.php.net\/manual\/en\/class.splfileinfo.php\&quot;&gt;http:\/\/www.php.net\/manual\/en\/class.splfileinfo.php&lt;\/a&gt;&quot;"},
                                                        {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method___construct", "name": "WebFilesystem\\WebFileInfo::__construct", "doc": "&quot;Construct a new WebFileInfo object&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_setFlags", "name": "WebFilesystem\\WebFileInfo::setFlags", "doc": "&quot;Set the object&#039;s flags&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getFlags", "name": "WebFilesystem\\WebFileInfo::getFlags", "doc": "&quot;Gets the object&#039;s flags value&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getExtension", "name": "WebFilesystem\\WebFileInfo::getExtension", "doc": "&quot;Gets the object extension (not defined before PHP 5.3.6)&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getRealPath", "name": "WebFilesystem\\WebFileInfo::getRealPath", "doc": "&quot;Gets the object realpath if found&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getFilename", "name": "WebFilesystem\\WebFileInfo::getFilename", "doc": "&quot;Gets the object file name as it was passed to the constructor (relative to &lt;code&gt;$root_dir&lt;\/code&gt;)&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_setRootDir", "name": "WebFilesystem\\WebFileInfo::setRootDir", "doc": "&quot;Sets the object&#039;s root directory&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getRootDir", "name": "WebFilesystem\\WebFileInfo::getRootDir", "doc": "&quot;Gets the object&#039;s root directory&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_setWebPath", "name": "WebFilesystem\\WebFileInfo::setWebPath", "doc": "&quot;Sets the object web path (relative to &lt;code&gt;$root_dir&lt;\/code&gt;)&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getWebPath", "name": "WebFilesystem\\WebFileInfo::getWebPath", "doc": "&quot;Gets the object&#039;s web path&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getRealWebPath", "name": "WebFilesystem\\WebFileInfo::getRealWebPath", "doc": "&quot;Gets the object&#039;s web real path (with the file name)&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_exists", "name": "WebFilesystem\\WebFileInfo::exists", "doc": "&quot;Check if the object exists in the server filesystem&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_pathExists", "name": "WebFilesystem\\WebFileInfo::pathExists", "doc": "&quot;Check if the object path (not the file itself but its container) exists in the server filesystem&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_rootDirExists", "name": "WebFilesystem\\WebFileInfo::rootDirExists", "doc": "&quot;Check if the object&#039;s root directory exists in the server filesystem&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getHumanReadableFilename", "name": "WebFilesystem\\WebFileInfo::getHumanReadableFilename", "doc": "&quot;Gets the directory name transformed to be displayed as a title&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getStat", "name": "WebFilesystem\\WebFileInfo::getStat", "doc": "&quot;Get the PHP standard &lt;code&gt;stat()&lt;\/code&gt; function result&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getMimeType", "name": "WebFilesystem\\WebFileInfo::getMimeType", "doc": "&quot;Get the &lt;code&gt;MIME&lt;\/code&gt; type of the object&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getCharset", "name": "WebFilesystem\\WebFileInfo::getCharset", "doc": "&quot;Get the &lt;code&gt;MIME&lt;\/code&gt; charset of the object&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFileInfo", "fromLink": "WebFilesystem/WebFileInfo.html", "link": "WebFilesystem/WebFileInfo.html#method_getMime", "name": "WebFilesystem\\WebFileInfo::getMime", "doc": "&quot;Get the full &lt;code&gt;MIME&lt;\/code&gt; information of the object&quot;"},
            
            {"type": "Class", "fromName": "WebFilesystem", "fromLink": "WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html", "name": "WebFilesystem\\WebFilesystem", "doc": "&quot;Commons static functions for the whole package&quot;"},
                                                        {"type": "Method", "fromName": "WebFilesystem\\WebFilesystem", "fromLink": "WebFilesystem/WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html#method_slashDirname", "name": "WebFilesystem\\WebFilesystem::slashDirname", "doc": "&quot;Returns a directory name with the trailing slash if needed&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystem", "fromLink": "WebFilesystem/WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html#method_getHumanReadableName", "name": "WebFilesystem\\WebFilesystem::getHumanReadableName", "doc": "&quot;Render a human readable string from a file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystem", "fromLink": "WebFilesystem/WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html#method_getExtensionName", "name": "WebFilesystem\\WebFilesystem::getExtensionName", "doc": "&quot;Returns the extension of a file name&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystem", "fromLink": "WebFilesystem/WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html#method_getTransformedFilesize", "name": "WebFilesystem\\WebFilesystem::getTransformedFilesize", "doc": "&quot;Returns a formatted file size in bytes or derived unit&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystem", "fromLink": "WebFilesystem/WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html#method_getDateTimeFromTimestamp", "name": "WebFilesystem\\WebFilesystem::getDateTimeFromTimestamp", "doc": "&quot;Returns a &lt;code&gt;DateTime&lt;\/code&gt; object from a timestamp&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystem", "fromLink": "WebFilesystem/WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html#method_isCommonFile", "name": "WebFilesystem\\WebFilesystem::isCommonFile", "doc": "&quot;Tests if a file name seems to be a valid one (also works for directories)&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystem", "fromLink": "WebFilesystem/WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html#method_isDotFile", "name": "WebFilesystem\\WebFilesystem::isDotFile", "doc": "&quot;Tests if a file name begins with a dot (also works for directories)&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystem", "fromLink": "WebFilesystem/WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html#method_isCommonImage", "name": "WebFilesystem\\WebFilesystem::isCommonImage", "doc": "&quot;Tests if a file name seems to have a common image&#039;s extension&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystem", "fromLink": "WebFilesystem/WebFilesystem.html", "link": "WebFilesystem/WebFilesystem.html#method_isCommonVideo", "name": "WebFilesystem\\WebFilesystem::isCommonVideo", "doc": "&quot;Tests if a file name seems to have a common video&#039;s extension&quot;"},
            
            {"type": "Class", "fromName": "WebFilesystem", "fromLink": "WebFilesystem.html", "link": "WebFilesystem/WebFilesystemIterator.html", "name": "WebFilesystem\\WebFilesystemIterator", "doc": "&quot;Special web&#039;s version of the PHP &gt;=5.3 standard class &lt;code&gt;FilesystemIterator&lt;\/code&gt; &lt;a href=\&quot;http:\/\/www.php.net\/manual\/en\/class.splfileinfo.php\&quot;&gt;http:\/\/www.php.net\/manual\/en\/class.splfileinfo.php&lt;\/a&gt;&quot;"},
                                                        {"type": "Method", "fromName": "WebFilesystem\\WebFilesystemIterator", "fromLink": "WebFilesystem/WebFilesystemIterator.html", "link": "WebFilesystem/WebFilesystemIterator.html#method___construct", "name": "WebFilesystem\\WebFilesystemIterator::__construct", "doc": "&quot;Overwriting the constructor to use the new &lt;code&gt;setFlags()&lt;\/code&gt; method and set a new default flags value&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystemIterator", "fromLink": "WebFilesystem/WebFilesystemIterator.html", "link": "WebFilesystem/WebFilesystemIterator.html#method_setFlags", "name": "WebFilesystem\\WebFilesystemIterator::setFlags", "doc": "&quot;Overwriting the default &lt;code&gt;setFlags()&lt;\/code&gt; method to accept new flags&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystemIterator", "fromLink": "WebFilesystem/WebFilesystemIterator.html", "link": "WebFilesystem/WebFilesystemIterator.html#method_getFlags", "name": "WebFilesystem\\WebFilesystemIterator::getFlags", "doc": "&quot;Overwriting the default &lt;code&gt;getFlags()&lt;\/code&gt; method to accept new flags&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystemIterator", "fromLink": "WebFilesystem/WebFilesystemIterator.html", "link": "WebFilesystem/WebFilesystemIterator.html#method_current", "name": "WebFilesystem\\WebFilesystemIterator::current", "doc": "&quot;Overwriting the default &lt;code&gt;current()&lt;\/code&gt; method to return a &lt;code&gt;WebFileInfo&lt;\/code&gt; object if so&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystemIterator", "fromLink": "WebFilesystem/WebFilesystemIterator.html", "link": "WebFilesystem/WebFilesystemIterator.html#method_rewind", "name": "WebFilesystem\\WebFilesystemIterator::rewind", "doc": "&quot;Overwriting the default &lt;code&gt;rewind()&lt;\/code&gt; method to skip files beginning with a dot if so&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystemIterator", "fromLink": "WebFilesystem/WebFilesystemIterator.html", "link": "WebFilesystem/WebFilesystemIterator.html#method_next", "name": "WebFilesystem\\WebFilesystemIterator::next", "doc": "&quot;Overwriting the default &lt;code&gt;next()&lt;\/code&gt; method to skip files beginning with a dot if so&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebFilesystemIterator", "fromLink": "WebFilesystem/WebFilesystemIterator.html", "link": "WebFilesystem/WebFilesystemIterator.html#method_count", "name": "WebFilesystem\\WebFilesystemIterator::count", "doc": "&quot;Implementation of the &lt;code&gt;count()&lt;\/code&gt; method of the &lt;code&gt;Countable&lt;\/code&gt; interface&quot;"},
            
            {"type": "Class", "fromName": "WebFilesystem", "fromLink": "WebFilesystem.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html", "name": "WebFilesystem\\WebRecursiveDirectoryIterator", "doc": "&quot;\n&quot;"},
                                                        {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method___construct", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::__construct", "doc": "&quot;\n&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_setFileClass", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::setFileClass", "doc": "&quot;Set a class name to build each item&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_getFileClass", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::getFileClass", "doc": "&quot;Get the class name to build each item&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_setFileValidationCallback", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::setFileValidationCallback", "doc": "&quot;Set a valid callback to validate each file item&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_getFileValidationCallback", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::getFileValidationCallback", "doc": "&quot;Set a valid callback to validate each file item&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_setDirectoryValidationCallback", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::setDirectoryValidationCallback", "doc": "&quot;Set a valid callback to validate each directory item&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_getDirectoryValidationCallback", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::getDirectoryValidationCallback", "doc": "&quot;Set a valid callback to validate each directory item&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_getChildren", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::getChildren", "doc": "&quot;Implementing the &lt;code&gt;getChildren()&lt;\/code&gt; method to return this class for directories items&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_getSubPath", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::getSubPath", "doc": "&quot;Implementing the &lt;code&gt;getSubPath()&lt;\/code&gt; method&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_getSubPathname", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::getSubPathname", "doc": "&quot;Implementing the &lt;code&gt;getSubPathname()&lt;\/code&gt; method&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_hasChildren", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::hasChildren", "doc": "&quot;Implementing the &lt;code&gt;hasChildren()&lt;\/code&gt; method&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_seek", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::seek", "doc": "&quot;Implementing the &lt;code&gt;seek()&lt;\/code&gt; method of the &lt;code&gt;Seekable&lt;\/code&gt; interface&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_current", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::current", "doc": "&quot;Overwriting the default &lt;code&gt;current()&lt;\/code&gt; method to use the file class option&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_rewind", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::rewind", "doc": "&quot;Overwriting the default &lt;code&gt;rewind()&lt;\/code&gt; method to skip files beginning with a dot if so&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_next", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::next", "doc": "&quot;Overwriting the default &lt;code&gt;next()&lt;\/code&gt; method to skip files beginning with a dot if so&quot;"},
                    {"type": "Method", "fromName": "WebFilesystem\\WebRecursiveDirectoryIterator", "fromLink": "WebFilesystem/WebRecursiveDirectoryIterator.html", "link": "WebFilesystem/WebRecursiveDirectoryIterator.html#method_recursiveCount", "name": "WebFilesystem\\WebRecursiveDirectoryIterator::recursiveCount", "doc": "&quot;Implementation of the &lt;code&gt;count()&lt;\/code&gt; method on each recursion items and sub-items&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


