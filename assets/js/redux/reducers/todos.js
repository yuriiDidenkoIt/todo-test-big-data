import { ADD_TODO, ADD_TODOS, UPDATE_TODO, REORDER_TODOS } from "../actionTypes";

const initialState = {
    todosIdsByPageId: {},
    byIds: {}
};

const todos = (state = initialState, action) => {
    switch (action.type) {
        case ADD_TODO: {
            const { todo } = action.payload;
            const todosIds = (state.todosIdsByPageId[1]).slice();
            if (todosIds.length > 50) todosIds.pop()
            return {
                ...state,
                todosIdsByPageId: {
                    ...state.todosIdsByPageId,
                    [1]: [todo.id, ...todosIds]
                },
                byIds: {
                    ...state.byIds,
                    [todo.id]: todo,
                }
            };
        }
        case ADD_TODOS: {
            const { todos, pageId, todosIds } = action.payload;
            if (pageId === 1) {
                state.todosIdsByPageId = {}
            }
            return {
                ...state,
                todosIdsByPageId: {
                    ...state.todosIdsByPageId,
                    [pageId]: todosIds
                },
                byIds: {
                    ...state.byIds,
                    ...todos
                }
            };
        }
        case UPDATE_TODO: {
            const { todo } = action.payload;
            return {
                ...state,
                byIds: {
                    ...state.byIds,
                    [todo.id]: todo
                }
            };
        }
        case REORDER_TODOS: {
            const { lastTodo, todoIndex, activePage } = action.payload;
            const reorderedTodos = (state.todosIdsByPageId[activePage]).slice();
            reorderedTodos.splice(todoIndex, 1);
            const result = lastTodo && lastTodo.id ? [...reorderedTodos, lastTodo.id] : reorderedTodos;
            return {
                ...state,
                todosIdsByPageId: {
                    ...state.todosIdsByPageId,
                    [activePage]: result,
                },
                byIds: {
                    ...state.byIds,
                    [lastTodo.id]: lastTodo
                }
            };
        }
        default:
            return state;
    }
}

export default todos;
