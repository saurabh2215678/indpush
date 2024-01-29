/* eslint-disable jsx-a11y/anchor-is-valid */
import React, { useState } from 'react'
import { logout } from '../Redux/slices/user';
import { useSelector, useDispatch } from "react-redux";
import { Link } from 'react-router-dom'
import {AnimatePresence, motion} from 'framer-motion';

function Nav() {
    const dispatch = useDispatch();
    const user = useSelector((state) => state.user.user);
    const [dropdown, setDropdown]= useState(false)

    function handleClick(){
        setDropdown(!dropdown);
    }

    function addClickHandler(className) {
        document.addEventListener('click', (event) => {
          const isClickInside = event.target.closest(`.${className}`);
          if(!isClickInside){
            handleDropdownClose()
          }
        });
      }
      
      document.addEventListener('click', ()=>{addClickHandler('navbar-nav')} )
  
      function handleDropdownClose(){
        setDropdown(false)
      }

      const logOut=()=>{
        dispatch(logout());
       }
  return (
    <div>
         <header className="navbar sticky-top flex-md-nowrap">
            <div className="col-md-3 col-lg-3 me-0 px-3 fs-6">
                <Link className="navbar-brand" to="/dashboard">
                    <i className="bi-box"></i>
                    IndPush
                </Link>
            </div>

            <button className="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span className="navbar-toggler-icon"></span>
            </button>

           
            <div className="navbar-nav me-lg-2">
                <div className="nav-item text-nowrap d-flex align-items-center">
           

                   

                    <div className="dropdown px-3">
                    <a href="#" onClick={handleClick} className="nav-link dropdown-toggle">
                    {user?.profile_picture ? <img
                            src={user?.profile_picture}
                            className="profile-image img-fluid"
                            alt=""
                            /> : <i class="bi bi-person-circle"></i>}
                            
                    </a>
                    <AnimatePresence>
                    {
                     dropdown?  <motion.ul
                     initial={{ y: 100 }}
                     animate={{ y: 0 }}
                     exit={{ y: 100, opacity: 0 }}
                     transition={{ duration: 0.3, type:'spring', stiffness:100 }}
                     className="dropdown-menu bg-white shadow">
                     <li>
                         <div className="dropdown-menu-profile-thumb d-flex">
                             <div className="d-flex flex-column">
                                 <small>{user?.name}</small>
                                 <a href={`mailto:${user?.email}`}>{user?.email}</a>
                             </div>
                         </div>
                     </li>
                     <li>
                        <Link to="/update-profile" onClick={handleDropdownClose} className="dropdown-item">
                        <i className="bi-person me-2"></i>
                             Update Profile
                        </Link>
                        
                     </li>
                     <li>
                        <Link to="/setting" onClick={handleDropdownClose} className="dropdown-item">
                            <i className="bi-gear me-2"></i>
                            Settings
                        </Link>
                        
                     </li>
                    
                     <li>
                         <a className="dropdown-item" href="help-center.html">
                             <i className="bi-question-circle me-2"></i>
                             Help
                         </a>
                     </li>
                     <li className="border-top mt-3 pt-2 mx-4">
                         <a className="dropdown-item ms-0 me-0" onClick={logOut} href="#">
                             <i className="bi-box-arrow-left me-2"></i>
                             Logout
                         </a>
                     </li>
                 </motion.ul> : ''   
                    }
                    </AnimatePresence>
                    {/* <div>
                        sssss
                    </div> */}
                        {/* <a className="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="images/medium-shot-happy-man-smiling.jpg" className="profile-image img-fluid" alt="">
                            <img
                            src="/images/social/medium-shot-happy-man-smiling.jpg"
                            className="profile-image img-fluid"
                            alt=""
                            />
                        </a> */}
                       
                    </div>
                </div>
            </div>
        </header>
    </div>
  )
}

export default Nav;
/* eslint-enable jsx-a11y/anchor-is-valid */