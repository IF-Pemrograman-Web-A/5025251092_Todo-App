let todos = [];

const list = document.querySelector(".todo-list");
const form = document.querySelector(".new-todo");


let db;

let request = indexedDB.open("TodoDB", 1);

request.onupgradeneeded = function(event) {
    db = event.target.result;
    db.createObjectStore("todos", {
        keyPath: "id",
        autoIncrement: true
    });
};

request.onsuccess = function(event) {
    db = event.target.result;
    loadTodos();
};

function loadTodos() {
    let transaction = db.transaction("todos", "readonly");
    let store = transaction.objectStore("todos");
    let request = store.getAll();

    request.onsuccess = function() {
        todos = request.result;
        showTodos();
    };
}

function showTodos() {
    list.innerHTML = "";

    todos.forEach(function(todo, index) {

        let item = document.createElement("div");
        item.classList.add("todo-item");

        item.innerHTML = `
            <div>
                <h3>${todo.title}</h3>
                <p>${todo.description}</p>
                <p>${todo.date}</p>
            </div>

            <input type="checkbox">

            <span class="status">
                ${todo.completed ? "Completed" : "Pending"}
            </span>

            <button>Edit</button>
            <button>Delete</button>
        `;

        let checkbox = item.querySelector("input");

        checkbox.checked = todo.completed;

        checkbox.addEventListener("change", function() {
            todo.completed = checkbox.checked;
            updateTodo(todo);
            showTodos();
        });

        let buttons = item.querySelectorAll("button");

        buttons[0].addEventListener("click", function() {
            todo.title = prompt("New title:", todo.title);
            updateTodo(todo);
            showTodos();
        });

        buttons[1].addEventListener("click", function() {
            let transaction = db.transaction("todos", "readwrite");
            transaction.objectStore("todos").delete(todo.id);

            todos.splice(index, 1);
            showTodos();
        });

        list.appendChild(item);
    });
}


form.addEventListener("submit", function(event) {
    event.preventDefault();

    let todo = {
        title: document.querySelector("#title").value,
        description: document.querySelector("#description").value,
        date: document.querySelector("#date").value,
        image: document.querySelector("#image").files[0]?.name || "",
        notification: document.querySelector("#notification").value,
        completed: false
    };

    let transaction = db.transaction("todos", "readwrite");
    transaction.objectStore("todos").add(todo);

    form.reset();

    setTimeout(loadTodos, 100);
});


function updateTodo(todo) {
    let transaction = db.transaction("todos", "readwrite");
    transaction.objectStore("todos").put(todo);
}


themeButton = document.querySelector("#theme-button");

themeButton.addEventListener("click", function() {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        localStorage.setItem("theme", "dark");
    } else {
        localStorage.setItem("theme", "light");
    }
});

if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-mode");
}


if ("serviceWorker" in navigator) {
    navigator.serviceWorker.register("sw.js");
}
