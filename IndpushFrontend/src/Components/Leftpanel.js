import React from 'react'
import { Link, useNavigate } from 'react-router-dom';
import { logout } from '../Redux/slices/user';
import { useDispatch, useSelector } from 'react-redux';


function Leftpanel() {
  const dispatch = useDispatch();
  const navigate = useNavigate();
  const user = useSelector((state) => state.user.user)
  if(user){
    navigate('/dashboard');
 }
 const logOut=()=>{
  dispatch(logout);
 }
  return (
    <nav id="sidebarMenu" className="col-md-3 col-lg-3 d-md-block sidebar collapse">
      <div className="position-sticky py-4 px-3 sidebar-sticky">
        <ul className="nav flex-column h-100">
        {/* <li className="nav-item">
          <Link to="/login" className="nav-link active">
            <i className="bi-house-fill me-2"></i>
            Login
          </Link>
        </li> */}

          <li className="nav-item">
            <a className="nav-link" href="#">
              <i className="bi-wallet me-2"></i>
              My Domainn
            </a>
          </li>

          <li className="nav-item">
            <a className="nav-link" href="#">
              <i className="bi-wallet me-2"></i>
              My Plan
            </a>
          </li>

          <li className="nav-item">
            <a className="nav-link" href="#">
              <i className="bi-person me-2"></i>
              Profile
            </a>
          </li>

          <li className="nav-item">
            <a className="nav-link" href="#">
              <i className="bi-gear me-2"></i>
              Settings
            </a>
          </li>

          <li className="nav-item">
            <a className="nav-link" href="help-center.html">
              <i className="bi-question-circle me-2"></i>
              Help Center
            </a>
          </li>

          <li className="nav-item featured-box mt-lg-5 mt-4 mb-4">
            <img src="images/credit-card.png" className="img-fluid" alt="" />
            <a className="btn custom-btn" href="#">
              AD Click Here
            </a>
          </li>

          <li className="nav-item border-top mt-auto pt-2">
            <a className="nav-link" onClick={logOut} href="#">
              <i className="bi-box-arrow-left me-2"></i>
              Logout
            </a>
          </li>
        </ul>
      </div>
    </nav>
  )
}

export default Leftpanel