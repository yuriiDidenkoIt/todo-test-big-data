import visibilityFilter from "./reducers/visibilityFilter";

export const getTodosState = (store) => store.todos;

export const getPaginationState = (store) => store.pagination;
export const getActiveOrderByLikes = (store) => store.orderByLikes;
export const getVisibilityFilter = (store) => store.visibilityFilter;

export const getActivePage = (store) => getPaginationState(store).activePage;
export const getPrevActivePage = (store) => getPaginationState(store).activePage - 1 || 0;

export const getTodoListIdsByActivePage = (store) =>
    getTodosState(store) ? getTodosState(store).todosIdsByPageId[getActivePage(store)] : [];

export const getTodoListIdsByPrevActivePage = (store) =>
    getTodosState(store) ? getTodosState(store).todosIdsByPageId[getPrevActivePage(store)] : [];

export const getTodoById = (store, id) =>
    getTodosState(store) ? { ...getTodosState(store).byIds[id], id } : null;

export const getTodos = (store) =>
    getTodoListIdsByActivePage(store) ? getTodoListIdsByActivePage(store).map((id) => getTodoById(store, id)) : [];

export const getLastTodoFromPrevPage = (store) => {
    const id = getTodoListIdsByPrevActivePage(store) ? getTodoListIdsByPrevActivePage(store).slice().pop() : null;

    if (id === null) return null;

    return getTodoById(store, id);
}

export const getLastTodoIdByActivePage = (store) => {
    return getTodoListIdsByActivePage(store) ? getTodoListIdsByActivePage(store).slice().pop() : null;
};

export const getLastTodoByActivePage = (store) => {
    const id = getLastTodoIdByActivePage(store)
    if (!id) return null;

    return getTodoById(store, id);
}

export const isThereTodosInActivePage = (store) => {
    return getTodoListIdsByActivePage(store) ? getTodoListIdsByActivePage(store).length > 0 : false;
}