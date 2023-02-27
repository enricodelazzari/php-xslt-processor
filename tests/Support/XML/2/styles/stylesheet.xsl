<?xml version="1.0" encoding="UTF-8"?>
<html xsl:version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<body>
<xsl:for-each select="breakfast_menu/food">
  <div>
    <span><xsl:value-of select="name"/> - </span>
    <xsl:value-of select="price"/>
    </div>
  <div>
    <p>
    <xsl:value-of select="description"/>
    <span> (<xsl:value-of select="calories"/> calories per serving)</span>
    </p>
  </div>
</xsl:for-each>
</body>
</html>