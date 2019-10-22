# News Plugin for CMSimple-XH

## Notes
The notes are simple ini files and are organized in categories. Each category is represented by a directory in the content base directory of the plugin. The single notes are separate files inside the corresponding category directory.

Changing the assignment of a note to a category is simply done by moving it to another category directory.

## File format
The format of the note files are of the ini type:

title = "This is the title of the note"
text = "`<p>`A description of the note that can contain html code. Special characters must be escaped for correct rendering.`</p>`"
created = {creation_timestamp}
modified = {timestamp_of_the_last_modification}
start = {timestamp_of_publishing}
expired = {timestamp_of_automatic_expiring}

## Plugin-call
The plugin call can contain two attribute strings:

```php
news("\{category_list\}"\[,"\{attributes\}"\])
```

The category list can consist one or more category names, separated by a comma. An empty string will show all notes from all categories.

## Category
The category parameter has two functions. Primary a comma separated list of categories can filter the corresponding notes. If the paramter is empty, all notes are shown.

The second use of the paramter is calling special functions. All function calls start with an _ character.

### \_add
The \_add function shows a form to enter a new note.

## Attributes
The attribute string can contain a comma separated list of attributes of the format *key=value*. The following attributes are supported.

### order
The order attributes defines the key that is used to sort the list of notes.

### dir
When an sort order key is defined, the dir attribute defines the direction (asc/desc).

### group
The notes can be grouped by a field, like category or created. When rendering the group name is shown as title with a following list of the corresponding notes.

### group_dir
The group_dir parameter (asc/desc) is used for sorting the group values. The group sorting is independent from the notes sorting.

### filter
The filter function can be used to reduce the amount of displayed notes. Depending on the filter it can have parameters, that are separated by the : character.

```php
filter={filtername}\[:param1\[:param2\]\]
```

If the result is grouped, the filter is applied to each group list separately.

#### filter=count:n
Limits the count of notes to n.

#### filter=time:\{time_string\}
The time filter can limit the notes to a certain time range using a range string.

i.e.
1 month, 3 days, 15 hours

### show
The show parameter selects the notes, that are shown. As default, only notes that are published and not expired are shown.

* **show=all**: all notes are shown.

#### ToDo
* **show=online** same as default: show only published and not expired notes
* **show=expired** show only expired notes
* **show=offline** show only notes, that are not published (ignores expired)