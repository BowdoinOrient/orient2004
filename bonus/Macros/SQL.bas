Attribute VB_Name = "SQL"

Dim SQLQuery As String
Dim SelectedSection

Function DBConnect()

Set Cnxn = New ADODB.Connection

Cnxn.Open "DSN=Orient MySQL"

End Function

Function DBQuery(SQLQuery As String)

End Function
Sub MySub()


Set Rec = New ADODB.Recordset

'SQLQuery = "INSERT INTO `article` ( `DATE` , `SECTION_ID` , `PRIORITY`, `TEXT`)" & _
    "VALUES ( " & _
    " '2003-09-26', '1', '3', 'This is an article.' " & _
    " );"

'SQLQuery = "Select * From Section"

Rec.Open SQLQuery, Cnxn, adOpenForwardOnly, adLockReadOnly, adCmdText



End Sub

Function DBDisconnect()

Cnxn.Close

End Function

Sub DBRoutine()

' Add data verification
' compile SQL update
' capsify author, job entries
' organize functions a little better.

Dim RunRoutine As Boolean
RunRoutine = True

If (Selection.Characters.Count <= 1) Then
    If MsgBox("Nothing is selected, so there will be no pull quote.  Upload anyway?", vbYesNo, "Prompt") = vbNo Then
        RunRoutine = False
    End If
End If
    

If (RunRoutine) Then

    Call init
    
    Dim ArticleText As String
    Dim ArticleDate As String
    'Dim ArticleSection As String
    'Dim ArticlePriority As String
    'Dim ArticleAuthor As String
    
    Call CopyArticlePullQuote
    
    ArticleText = GetArticleText
    
    ArticleDate = GetArticleDate
    
    'Call DBConnect
    
    'ArticleSection = GetArticleSection
    
    'ArticlePriority = InputBox("What is the article's priority?", "Prompt", "0")
    
    'ArticleTitle = InputBox("What is the article's title?", "Prompt", "0")
    
    ArticlePullQuote = GetArticlePullQuote
    
    CreateForm ArticleText, ArticlePullQuote, ArticleDate
    
    'ArticlePullQuote = InputBox("You have selected the following pullquote.  Change it if you like.", "Prompt", ArticlePullQuote)
    
    ''ArticleAuthor = InputBox("Who is the article's author?", "Prompt", "0")
    'ArticleAuthor = GetArticleAuthor
    'ArticleAuthor = UCase(ArticleAuthor)
    
    'ArticleJob = InputBox("What is the author's job?", "Prompt", "0")
    'ArticleJob = UCase(ArticleJob)
    
    'ArticlePhoto = InputBox("What is the photo's filename?", "Prompt", "")
    
    'ArticleThumb = InputBox("What is the thumbnail's filename?", "Prompt", "0")
    
    'If MsgBox("Would you like the photo on the left (otherwise right)? ", vbYesNo, "Prompt") Then
    '    ArticlePhotoPosition = "right"
    'Else
    '    ArticlePhotoPostion = "left"
    'End If
    
    'ArticleCaption = InputBox("What is the photo caption?", "Prompt", "")
    
    'ArticleCredit = InputBox("What is the photo credit?", "Prompt", "")
    
    'mySQLQuery = "INSERT INTO `article` ( `DATE` , `SECTION_ID` , `PRIORITY` , `AUTHOR_ID` , `AUTHOR_JOB` , `PHOTO_FILENAME` , `THUMB_FILENAME` , `THUMB_POSITION` , `PHOTO_CAPTION` , `PHOTO_CREDIT` , `TITLE` , `TEXT` , `PULLQUOTE` )" & _
        " VALUES ( " & _
    "'" & ArticleDate & "', '" & ArticleSection & "', '" & ArticlePriority & "', '" & _
        ArticleAuthor & "', '" & ArticleJob & "', '" & ArticlePhoto & "', '" & ArticleThumb & "', '" & ArticlePhotoPosition & _
        "', '" & ArticleCaption & "', '" & ArticleCredit & "', '" & ArticleTitle & "', '" & ArticleText & "', '" & ArticlePullQuote & "');"
    
    'Set Rec = New ADODB.Recordset
    'Rec.Open mySQLQuery, Cnxn ', adOpenForwardOnly, adLockReadOnly, adCmdText
    
    'Call DBDisconnect
    
    'Debug.Print mySQLQuery
    
    Application.Quit
    
End If

End Sub

Public Sub SetSelectedSection(theSection)

SelectedSection = theSection

End Sub

Function GetArticleSection()

'Get section names

Set Rec = New ADODB.Recordset
Rec.Open "Select * From Section", Cnxn, adOpenForwardOnly, adLockReadOnly, adCmdText
While Not Rec.EOF
    Section.SectionChooser.AddItem Rec.Fields(3)
    Rec.MoveNext
Wend

'Select the section
Section.Show
While Section.Visible
Wend
Unload Section


'Set Rec = New ADODB.Recordset
'Rec.Open "Select ABBREV From Section", Cnxn, adOpenForwardOnly, adLockReadOnly, adCmdText
'While Not Rec.EOF
'    Section.SectionChooser.AddItem Rec.Fields(0)
'    Rec.MoveNext
'Wend

'Find the section's ID
Set Rec = New ADODB.Recordset
Rec.Open "Select ID From Section WHERE ABBREV = '" & SelectedSection & "'", Cnxn, adOpenForwardOnly, adLockReadOnly, adCmdText
GetArticleSection = Rec.Fields(0)


End Function

Function GetArticleDate()

Dim UpcomingFriday As Date
UpcomingFriday = Now
While Weekday(UpcomingFriday) <> vbFriday
    UpcomingFriday = DateAdd("d", 1, UpcomingFriday)
Wend

'GetArticleDate = InputBox("What is the article's date?", "Prompt", Format(UpcomingFriday, "yyyy-mm-dd"))
GetArticleDate = Format(UpcomingFriday, "yyyy-mm-dd")

End Function


Function GetArticleAuthor()

'Get section names

Set Rec = New ADODB.Recordset
Rec.Open "Select * From Author", Cnxn, adOpenForwardOnly, adLockReadOnly, adCmdText
While Not Rec.EOF
    Section.SectionChooser.AddItem Rec.Fields("NAME")
    Rec.MoveNext
Wend

'Select the section
Section.Show
While Section.Visible
Wend
Unload Section


'Set Rec = New ADODB.Recordset
'Rec.Open "Select ABBREV From Section", Cnxn, adOpenForwardOnly, adLockReadOnly, adCmdText
'While Not Rec.EOF
'    Section.SectionChooser.AddItem Rec.Fields(0)
'    Rec.MoveNext
'Wend

'Find the section's ID
Set Rec = New ADODB.Recordset
Rec.Open "Select ID From AUTHOR WHERE NAME = '" & SelectedSection & "'", Cnxn, adOpenForwardOnly, adLockReadOnly, adCmdText
GetArticleAuthor = Rec.Fields(0)


End Function
