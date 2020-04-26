import React from 'react';
import { useSelector, useDispatch } from 'react-redux';
import classNames from 'classnames'
import PaginationSegment from './PaginationSegment';
import { getPaginationState } from '../../redux/selectors';
import usePaginationActions from "../../hooks/usePaginationActions";

import './Pagination.css'

const Pagination = () => {
    const dispatch = useDispatch();
    const { activePage, pageCount } = useSelector(getPaginationState);
    const {
        toPreviousPage,
        toNextPage,
        toFirstPage,
        toLastPage
    } = usePaginationActions(activePage, pageCount, dispatch);

    return (
        <div className="pagination-container">
            <div className={classNames({ disabled: activePage === 1 })} children="<<" onClick={toFirstPage} />
            <div className={classNames({ disabled: activePage === 1 })} children="<" onClick={toPreviousPage} />
            <PaginationSegment activePage={activePage} pageCount={pageCount} dispatch={dispatch} />
            <div className={classNames({ disabled: activePage === pageCount })} children=">" onClick={toNextPage} />
            <div className={classNames({ disabled: activePage === pageCount })} children=">>" onClick={toLastPage} />
        </div>
    );
}

export default Pagination;