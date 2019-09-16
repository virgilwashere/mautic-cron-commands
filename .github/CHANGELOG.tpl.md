{{ if .Versions -}}{{ $latest := index .Versions 0 }}---
author:     Virgil <virgil@virgilwashere.co>
date:       {{ datetime "2006-01-02" $latest.Tag.Date }}
version:    {{ $latest.Tag.Name }}
copyright:  {{ datetime "2006" $latest.Tag.Date }} Virgil. All rights reserved.
license:    GPL3
link:       <{{ .Info.RepositoryURL }}>
{{ end -}}---
# 📃 {{ .Info.Title }}

All notable changes to this project will be documented in this file.

This project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

{{ if .Versions -}}
<a name="unreleased"></a>

## 🚧 [Unreleased]

{{ if .Unreleased.CommitGroups -}}{{ range .Unreleased.CommitGroups -}}
### {{ .Title }}

{{ range .Commits -}}
- {{ if .Scope }}**{{ .Scope }}:** {{ end }}{{ .Subject }}
{{ end }}
{{ end -}}
{{ end -}}
{{ end -}}

{{ range .Versions }}<a name="{{ .Tag.Name }}"></a>

## 🔖{{ if .Tag.Previous }} [{{ .Tag.Name }}]{{ else }}{{ .Tag.Name }}{{ end }} - {{ datetime "2006-01-02" .Tag.Date }}

{{ range .CommitGroups -}}
### {{ .Title }}

{{ range .Commits -}}
- {{ if .Scope }}**{{ .Scope }}:** {{ end }}{{ .Subject }}
{{ end }}
{{ end -}}

{{- if .MergeCommits -}}### Pull Requests

{{ range .MergeCommits -}}
- {{ .Header }}
{{ end }}
{{ end -}}

{{- if .NoteGroups -}}{{ range .NoteGroups -}}<details><summary>🔍{{ .Title }} details</summary>
{{ range .Notes }}
{{ .Body }}
{{ end }}
</details>

{{ end -}}
{{ end -}}
{{ end -}}
{{- if .Versions }}
[Unreleased]: <{{ .Info.RepositoryURL }}/compare/{{ $latest := index .Versions 0 }}{{ $latest.Tag.Name }}...HEAD>
{{ range .Versions -}}
{{ if .Tag.Previous -}}
[{{ .Tag.Name }}]: <{{ $.Info.RepositoryURL }}/compare/{{ .Tag.Previous.Name }}...{{ .Tag.Name }}>
{{ end -}}
{{ end -}}
{{ end -}}
