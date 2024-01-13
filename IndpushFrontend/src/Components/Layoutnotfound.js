import React from 'react'
import Nav from './Nav'
import { Outlet } from 'react-router-dom'

function Layoutnotfound() {
  return (
    <div>
        <Nav />
        <Outlet />
    </div>
  )
}

export default Layoutnotfound