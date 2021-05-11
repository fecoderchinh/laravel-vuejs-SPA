import Vue from 'vue'
import Child from './Child'
import Button from './Button'
import Card from './Card'
import Box from './Box'
import Checkbox from './Checkbox'

import * as icons from '~/components/Icons'

import { HasError, AlertError, AlertSuccess } from 'vform'

// Components that are registered globaly.
[
  Child,
  Button,
  Card,
  Box,
  Checkbox,
  HasError,
  AlertError,
  AlertSuccess,
  icons.EllipseSvg,
  icons.ListSvg,
  icons.CloseSvg,
  icons.SearchSvg,
  icons.MenubarSvg,
  icons.CarretSvg,
  icons.SettingSvg,
  icons.UserSvg,
  icons.HomeSvg,
  icons.DashboardSvg,
  icons.TasksSvg,
  icons.RoundedArrowSvg,
  icons.CommentSvg,
  icons.InfoSvg,
  icons.EditSvg,
  icons.RemoveSvg,
  icons.FolderSvg,
  icons.FileCheckSvg,
  icons.EyeFillSvg,
  icons.EyeSlashSvg,
  icons.EyeSvg,
  icons.TagsSvg,
  icons.InfoSvg,
  icons.GithubSvg,
  icons.LockSvg
].forEach(Component => {
  Vue.component(Component.name, Component)
})
