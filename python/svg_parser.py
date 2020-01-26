import math
import xml.sax

from draw_action import DrawAction


class SvgParser(xml.sax.ContentHandler):

    def __init__(self):
        xml.sax.ContentHandler.__init__(self)
        self.current_data = ""
        self.draw_list = []
        self.draw_list.append(DrawAction(t=DrawAction.PEN_UP))

    def startElement(self, tag, attributes):
        self.current_data = tag
        if tag == "path":
            path = attributes["d"]
            path_data = path.split(' ')
            moved_to_start_pos = False
            start_pos_x = 0
            start_pos_y = 0
            self.draw_list.append(DrawAction(t=DrawAction.PEN_UP))

            for item in path_data:
                sitem = item.strip()

                if sitem == 'M' or sitem == 'C':
                    continue

                if sitem == 'Z':
                    self.draw_list.append(DrawAction(DrawAction.PEN_MOVE, start_pos_x, start_pos_y))
                    continue

                pos = item.split(',')
                x = math.floor(float(pos[0]))
                y = math.floor(float(pos[1]))

                if moved_to_start_pos is False:
                    moved_to_start_pos = True
                    start_pos_x = x
                    start_pos_y = y
                    self.draw_list.append(DrawAction(DrawAction.PEN_MOVE, x, y))
                    self.draw_list.append(DrawAction(t=DrawAction.PEN_DOWN))

                self.draw_list.append(DrawAction(DrawAction.PEN_MOVE, x, y))
