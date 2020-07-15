//抓容器
let newcoursesList = document.getElementsByClassName[0]('coursesList');
//建立新的li
let newLi = document.createElement('li');
//建立textNode
let coursesCategory = document.createTextNode('<a class="nav-link" href="./coursesPage.php">課程列表<span class="sr-only">(current)</span></a>')
//將文字推進li
newLi.appendChild(coursesCategory);
//將li推進容器
newcoursesList.appendChild(newLi);
