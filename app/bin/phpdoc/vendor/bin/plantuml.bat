@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../jawira/plantuml/bin/plantuml
bash "%BIN_TARGET%" %*
